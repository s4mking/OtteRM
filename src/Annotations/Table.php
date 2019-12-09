<?php

namespace OtteRM\Annotations;

/** @Annotation */
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
