<?php
$file = "resources/views/ai/history.blade.php";
$content = file_get_contents($file);
$lines = explode("\n", $content);
$newLines = [];
$foundEndSection = false;

for ($i = 0; $i < count($lines); $i++) {
    $line = $lines[$i];
    
    // We know the problem is around line 286-288 where multiple @endsection appear consecutively.
    if (trim($line) === '@endsection') {
        // If the previous line was also @endsection or @include("components.seller-chat-drawer"),
        // let's be careful. The error is line 288 is an extra @endsection.
        if ($i == 286 || $i == 287) {
            continue; // Skip the extra endsections we injected by accident.
        }
    }
    
    $newLines[] = $line;
}

// Ensure there is exactly ONE @endsection after @include('components.seller-chat-drawer')
// Wait, the correct structure is:
// @include('components.seller-chat-drawer')
// @endsection
// @section('scripts')

$content = implode("\n", $newLines);
// Now we do a str_replace to ensure correctness
$content = str_replace(
    "@include(\"components.seller-chat-drawer\")\n@endsection\n@endsection", 
    "@include(\"components.seller-chat-drawer\")\n@endsection", 
    $content
);
$content = str_replace(
    "@include(\"components.seller-chat-drawer\")\n@section('scripts')", 
    "@include(\"components.seller-chat-drawer\")\n@endsection\n@section('scripts')", 
    $content
);

file_put_contents($file, $content);
echo "Fixed!";
