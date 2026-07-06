<?php
$controllers = glob(__DIR__ . '/../app/Controllers/*.php');
$results = [];
foreach ($controllers as $file) {
    $content = file_get_contents($file);
    if (preg_match_all('/page\s*=>\s*\'([^\']+)\'/', $content, $matches)) {
        foreach ($matches[1] as $page) {
            $path = __DIR__ . '/../app/Views/' . str_replace('/', DIRECTORY_SEPARATOR, $page) . '.php';
            $exists = file_exists($path) ? 'OK' : 'MISSING';
            $results[] = [basename($file), $page, $exists, $path];
        }
    }
}
foreach ($results as $r) {
    echo sprintf("%s => %s => %s\n", $r[0], $r[1], $r[2]);
}
