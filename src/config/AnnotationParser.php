<?php

namespace OtteRM\config;

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
class Table
{
    private $name;

    public function __construct(array $values)
    {
        $this->name = $values['name'];
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
class Type
{
    private $type;

    public function __construct(array $values)
    {

        $this->type = $values['type'];
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
