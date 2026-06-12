<?php

$path = $argv[1] ?? null;

if ($path === null || ! is_file($path)) {
    fwrite(STDERR, "Usage: php tools/extract_pdf_text.php <file.pdf>\n");
    exit(1);
}

$pdf = file_get_contents($path);
preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $pdf, $streams);

$decodedStreams = [];

foreach ($streams[1] as $stream) {
    $decoded = @gzuncompress($stream);

    if ($decoded === false) {
        $decoded = @gzdecode($stream);
    }

    if ($decoded !== false) {
        $decodedStreams[] = $decoded;
    }
}

$map = [];

foreach ($decodedStreams as $stream) {
    foreach (['bfchar', 'bfrange'] as $type) {
        preg_match_all('/begin' . $type . '(.*?)end' . $type . '/s', $stream, $sections);

        foreach ($sections[1] as $section) {
            if ($type === 'bfchar') {
                preg_match_all('/<([0-9A-Fa-f]+)>\s*<([0-9A-Fa-f]+)>/', $section, $pairs, PREG_SET_ORDER);

                foreach ($pairs as $pair) {
                    $map[strtoupper($pair[1])] = unicodeHexToUtf8($pair[2]);
                }
            } else {
                preg_match_all('/<([0-9A-Fa-f]+)>\s*<([0-9A-Fa-f]+)>\s*<([0-9A-Fa-f]+)>/', $section, $ranges, PREG_SET_ORDER);

                foreach ($ranges as $range) {
                    $from = hexdec($range[1]);
                    $to = hexdec($range[2]);
                    $dest = hexdec($range[3]);
                    $width = strlen($range[1]);

                    for ($code = $from; $code <= $to; $code++) {
                        $map[strtoupper(str_pad(dechex($code), $width, '0', STR_PAD_LEFT))] = unicodeCodepointToUtf8($dest++);
                    }
                }
            }
        }
    }
}

foreach ($decodedStreams as $index => $stream) {
    preg_match_all('/\((?:\\\\.|[^\\\\)])*\)|<([0-9A-Fa-f\s]{2,})>/s', $stream, $matches);

    $lines = [];

    foreach ($matches[0] as $text) {
        $bytes = str_starts_with($text, '<')
            ? hex2bin(preg_replace('/[^0-9A-Fa-f]/', '', substr($text, 1, -1)))
            : pdfLiteralBytes(substr($text, 1, -1));

        $decoded = decodeWithMap($bytes, $map);
        $decoded = trim(preg_replace('/\s+/', ' ', $decoded));

        if ($decoded !== '' && $decoded !== 'id-ID' && $decoded !== 'id') {
            $lines[] = $decoded;
        }
    }

    if ($lines !== []) {
        echo "--- stream {$index} ---\n";
        echo implode("\n", $lines) . "\n";
    }
}

function decodeWithMap(string $bytes, array $map): string
{
    $result = '';
    $length = strlen($bytes);

    for ($i = 0; $i < $length;) {
        $two = $i + 1 < $length ? strtoupper(bin2hex(substr($bytes, $i, 2))) : null;
        $one = strtoupper(bin2hex($bytes[$i]));

        if ($two !== null && isset($map[$two])) {
            $result .= $map[$two];
            $i += 2;
            continue;
        }

        if (isset($map[$one])) {
            $result .= $map[$one];
            $i++;
            continue;
        }

        $result .= ctype_print($bytes[$i]) ? $bytes[$i] : ' ';
        $i++;
    }

    return $result;
}

function pdfLiteralBytes(string $value): string
{
    $value = preg_replace_callback('/\\\\([0-7]{1,3}|.)/s', function (array $match): string {
        $escape = $match[1];

        if (preg_match('/^[0-7]+$/', $escape)) {
            return chr(octdec($escape));
        }

        return match ($escape) {
            'n' => "\n",
            'r' => "\r",
            't' => "\t",
            'b' => "\b",
            'f' => "\f",
            default => $escape,
        };
    }, $value);

    return $value;
}

function unicodeHexToUtf8(string $hex): string
{
    return @mb_convert_encoding(hex2bin($hex), 'UTF-8', 'UTF-16BE') ?: '';
}

function unicodeCodepointToUtf8(int $codepoint): string
{
    return mb_chr($codepoint, 'UTF-8');
}
