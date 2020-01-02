<?php

namespace OtteRM\Annotations;

/** @Annotation */
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
