<?php

namespace App;

use Threaded;

class FileReader extends Threaded
{
    public $response;

    /**
     * @var Counter
     */
    private $counter;

    /**
     * @var array
     */
    private $search = [',', '.', ' ', '/', ':', ';', '|', '\\', "\n", "\t", "\r", "\r\n", "="];

    /**
     * @var string
     */
    private $filename;

    public function __construct(string $filename, Counter $counter)
    {
        $this->filename = $filename;
        $this->counter = $counter;
    }

    /**
     * Считаем кол-во слов и записываем в синхронизированный счетчик
     */
    public function run()
    {
        $file = file_get_contents($this->filename);
        $replaced = str_replace((array) $this->search, '|', $file);
        $array = explode('|', $replaced);
        $arrayFiltered = array_filter($array, function ($item) {
            return (boolean) $item;
        });

        $count = count($arrayFiltered);

        $this->counter->increaseCounter($count);
    }
}
