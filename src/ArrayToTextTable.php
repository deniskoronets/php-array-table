<?php

class ArrayToTextTable
{
    private $data;

    private $columnsList = [];

    private $columnsLength = [];

    private $totalLength = 0;

    private $result = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function calcColumnsList()
    {
        $this->columnsList = array_keys($this->data[0]);
    }

    public function calcColumnsLength()
    {
        foreach ($this->data as $row) {
            foreach ($this->columnsList as $column) {
                $this->columnsLength[$column] = max(
                    isset($this->columnsLength[$column]) ? $this->columnsLength[$column] : 0,
                    strlen($row[$column]),
                    strlen($column)
                );
            }
        }

        $this->totalLength = array_sum($this->columnsLength);
    }

    public function lineSeparator()
    {
        $tmp = '';

        foreach ($this->columnsList as $column) {
            $tmp .= '+' . str_repeat('-', $this->columnsLength[$column] + 2) . '+';
        }

        $this->result[] = $tmp;
    }

    public function renderHeader()
    {
        $this->lineSeparator();

        $tmp = '';

        foreach ($this->columnsList as $column) {
            $tmp .= '| ' . $column . ' ' . str_repeat(' ', $this->columnsLength[$column] - strlen($column)) . '|';
        }

        $this->result[] = $tmp;

        $this->lineSeparator();
    }

    public function render()
    {
        if (empty($this->data)) {
            return 'Empty';
        }

        $this->calcColumnsList();
        $this->calcColumnsLength();

        $result = &$this->result;

        $this->renderHeader();

        foreach ($this->data as $row) {

            $tmp = '';

            foreach ($this->columnsList as $column) {
                $tmp .= '| ' . $row[$column] . ' ' . str_repeat(' ', $this->columnsLength[$column] - strlen($row[$column])) . '|';
            }

            $this->result[] = $tmp;
        }

        $this->lineSeparator();

        return str_replace(
            ['++', '||'],
            ['+', '|'],
            implode(PHP_EOL, $result)
        );
    }
}