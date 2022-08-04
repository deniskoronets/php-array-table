<?php

namespace dekor;

use function array_keys;

/**
 * @author Denis Koronets
 */
class ArrayToTextTable
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var bool
     */
    private $paddingRight = true;

    /**
     * @var array
     */
    private $format;

    /**
     * @var array
     */
    private $columnsList = [];

    /**
     * @var int
     */
    private $maxLineLength = 40;

    /**
     * @var array
     */
    private $columnsLength = [];

    /**
     * @var array
     */
    private $result = [];

    /**
     * @var string
     */
    private $charset = 'UTF-8';

    /**
     * @var bool
     */
    private $renderHeader = true;

    public function __construct(array $data, ?array $format = null)
    {
        $this->data = $data;
        $this->format = $format;

        if ($format && array_key_exists('padding', $format) && $format['padding'] === 'left') {
            $this->paddingRight = false;
        }
    }

    /**
     * Set custom charset for columns values
     *
     * @param $charset
     *
     * @return \dekor\ArrayToTextTable
     * @throws \Exception
     */
    public function charset($charset)
    {
        if (!in_array($charset, mb_list_encodings())) {
            throw new \Exception(
                'This charset `' . $charset . '` is not supported by mbstring.' .
                'Please check it: http://php.net/manual/ru/function.mb-list-encodings.php'
            );
        }

        $this->charset = $charset;

        return $this;
    }

    /**
     * Set mode to print no header in the table
     *
     * @return self
     */
    public function noHeader()
    {
        $this->renderHeader = false;

        return $this;
    }

    /**
     * @param int $length
     *
     * @return self
     * @throws \Exception
     */
    public function maxLineLength($length)
    {
        if ($length < 3) {
            throw new \Exception('Minimum length for cropper is 3 sumbols');
        }

        $this->maxLineLength = $length;

        return $this;
    }

    /**
     * Build your ascii table and return the result
     *
     * @return string
     */
    public function render()
    {
        if (empty($this->data)) {
            return 'Empty';
        }

        $this->calcColumnsList();
        $this->calcColumnsLength();

        /** render section **/
        $this->renderHeader();
        $this->renderBody();
        $this->lineSeparator();
        /** end render section **/

        return str_replace(
            ['++', '||'],
            ['+', '|'],
            implode(PHP_EOL, $this->result)
        );
    }

    /**
     * Calculates list of columns in data
     */
    protected function calcColumnsList()
    {
        $this->columnsList = array_keys(reset($this->data));
    }

    /**
     * Calculates length for string
     *
     * @param $value
     *
     * @return int
     */
    protected function length($value)
    {
        if ($this->format && array_key_exists('number', $this->format) && (is_int($value) || is_float($value))) {
            $value = sprintf($this->format['number'], $value);
        }

        return mb_strlen($value, $this->charset);
    }

    /**
     * Calculate maximum string length for each column
     */
    private function calcColumnsLength()
    {
        foreach ($this->data as $row) {
            if ($row === '---') {
                continue;
            }
            foreach ($this->columnsList as $column) {
                $this->columnsLength[$column] = max(
                    isset($this->columnsLength[$column])
                        ? $this->columnsLength[$column]
                        : 0,
                    $this->length($row[$column]),
                    $this->length($column)
                );
            }
        }
    }

    /**
     * Append a line separator to result
     */
    private function lineSeparator()
    {
        $tmp = '';

        foreach ($this->columnsList as $column) {
            $tmp .= '+' . str_repeat('-', $this->columnsLength[$column] + 2) . '+';
        }

        $this->result[] = $tmp;
    }

    /**
     * @param $columnKey
     * @param $value
     *
     * @return string
     */
    private function column($columnKey, $value)
    {
        if ($this->format && array_key_exists('number', $this->format) && (is_int($value) || is_float($value))) {
            $value = sprintf($this->format['number'], $value);
        }

        if ($this->paddingRight) {
            return '| ' . $value . ' ' . str_repeat(' ', $this->columnsLength[$columnKey] - $this->length($value)) . '|';
        } else {
            return '| ' . str_repeat(' ', $this->columnsLength[$columnKey] - $this->length($value)) . $value . ' |';
        }
    }

    /**
     * Render header part
     *
     * @return void
     */
    private function renderHeader()
    {
        $this->lineSeparator();

        if (!$this->renderHeader) {
            return;
        }

        $tmp = '';

        foreach ($this->columnsList as $column) {
            $tmp .= $this->column($column, $column);
        }

        $this->result[] = $tmp;

        $this->lineSeparator();
    }

    /**
     * Render body section of table
     *
     * @return void
     */
    private function renderBody()
    {
        foreach ($this->data as $row) {
            if ($row === '---') {
                $this->lineSeparator();
                continue;
            }

            $tmp = '';

            foreach ($this->columnsList as $column) {
                $tmp .= $this->column($column, $row[$column]);
            }

            $this->result[] = $tmp;
        }
    }
}
