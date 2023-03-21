<?php

namespace dekor\formatters;

class SprintfFormatter extends BaseColumnFormatter
{
    protected function applyBefore($value, $formatterValue)
    {
        return sprintf($formatterValue, $value);
    }

    protected function applyAfter($value, $formatterValue)
    {
        return $value;
    }
}
