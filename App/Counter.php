<?php

namespace App;

use Threaded;

class Counter extends Threaded
{

    /**
     * @var int
     */
    private $value = 0;

    /**
     * @param int $value
     */
    public function increaseCounter(int $value)
    {
        // Синхронизируем запись, чтобы не терять значение
        $this->synchronized(function () use ($value) {
            $this->value += $value;
        });
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
