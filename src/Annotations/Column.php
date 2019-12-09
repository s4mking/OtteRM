<?php

namespace OtteRM\Annotations;

/** @Annotation */
class Column
{
    private $column;

    public function __construct(array $values)
    {
        $this->column = $values['column'];
    }

    /**
     * Get the value of column
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Set the value of column
     *
     * @return  self
     */
    public function setColumn($column)
    {
        $this->column = $column;

        return $this;
    }
}
