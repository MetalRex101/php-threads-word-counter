<?php

require_once 'vendor/autoload.php';

use App\Counter;
use App\FileReader;

$path = $argv[1];

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
$counter = new Counter(); // Объект счетчика
$pool = new Pool(4); // Пулл потоков


// Перебираем рекурсивно директорию
// и для текстовых файлов делаем подсчет кол-ва слов
foreach ($iterator as $info) {
    if ($info->isFile() && $info->getExtension() == 'txt') {
        $pool->submit(new FileReader($info->getPathname(), $counter));
    }
}

while ($pool->collect()) {
}

$pool->shutdown();
echo 'count words: ' . $counter->getValue();
