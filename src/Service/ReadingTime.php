<?php

namespace App\Service;

class ReadingTime
{
    public function calculate(string $content): string
    {
        //@todo write logic here
        return ceil(count(explode(" ", $content)) / 250) . " min";
    }
}
