<?php

namespace dekor\formatters;

class AlignFormatter extends BaseColumnFormatter
{
    protected function applyBefore($value, $formatterValue)
    {
        return true;
    }

    protected function applyAfter($value, $formatterValue)
    {
        $length = mb_strlen($value);

        $value = trim($value);
        $trimLength = mb_strlen($value);



        //switch ($this->)
    }
}