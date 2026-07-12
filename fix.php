<?php
$c = file_get_contents("resources/views/ai/history.blade.php");
$lines = explode("\n", $c);
$newLines = [];
foreach ($lines as $i => $line) {
    if ($i === 286 || $i === 287) {
        if (trim($line) === '@endsection') {
            continue; // delete
        }
    }
    $newLines[] = $line;
}
file_put_contents("resources/views/ai/history.blade.php", implode("\n", $newLines));
echo "Fixed";
