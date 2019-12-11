<?php

namespace OtteRM\config;

use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use ReflectionProperty;

class Translator
{

    private $annotationReader;

    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();
    }

    public function getParamsObjects($object)
    {
        $arrayResult = [];
        $reflClass = new ReflectionClass(get_class($object));
        $props = $reflClass->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            $propName = ($prop->name);
            $property = new ReflectionProperty(get_class($object), $propName);
            $propType = $this->annotationReader->getPropertyAnnotations($property);
            $arrayResult[$propName] = [$propType[0]->getColumn(), $propType[1]->getType()];
        }
        return $arrayResult;
    }
}
