<?php
//class principal où on va passer la connection, ainsi que toutes les différentes actions possibles de l'orm
namespace OtteRM;

use ReflectionClass;

use Examples\Entity as Entity;
use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionProperty;
use Symfony\Component\Yaml\Yaml;

class EntityManager
{

    private $config;
    private $connection;

    public function __construct()
    { }


    public function createConnection()
    {
        $params = Yaml::parseFile('Config/parameters.yml');
        $connectionParams = [
            'dbname' => $params['db']['name'],
            'user' => $params['db']['user'],
            'password' => $params['db']['password'],
            'host' => $params['db']['host'],
            'port' => $params['db']['port'],
        ];
        try {
            $connection = new \PDO('mysql:host=' . $connectionParams['host'] . ';dbname=' . $connectionParams['dbname'] . ';port=' . $connectionParams['port'], $connectionParams['user'], $connectionParams['password']);
            echo "connect success";
            $this->connection = $connection;
        } catch (\PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }


    public function updateSchemaDB()
    {
        $annotationReader = new AnnotationReader();
        $entityFiles = scandir('Examples/Entity');
        array_shift($entityFiles);
        array_shift($entityFiles);
        foreach ($entityFiles as $entity) {
            $entity = str_replace(".php", "", $entity);
            $reflClass = new ReflectionClass('Examples\Entity\\' . $entity);
            $classAnnotations = $annotationReader->getClassAnnotations($reflClass);
            $props = $reflClass->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC);
            foreach ($props as $prop) {
                $propName = ($prop->name);
                $property = new ReflectionProperty('Examples\Entity\\' . $entity, $propName);
                $propType = $annotationReader->getPropertyAnnotations($property);
            }
        }
    }
    public function getTable($class)
    {
        $annotationReader = new AnnotationReader();
        $reflClass = new ReflectionClass('Examples\Entity\\' . $class);
        $classAnnotations = $annotationReader->getClassAnnotations($reflClass);
        return $classAnnotations[0]->getName();
    }
    public function getParamsObjects($class)
    {
        $arrayResult = [];
        $annotationReader = new AnnotationReader();
        $reflClass = new ReflectionClass('Examples\Entity\\' . $class);
        $props = $reflClass->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            $propName = ($prop->name);
            $property = new ReflectionProperty('Examples\Entity\\' . $class, $propName);
            $propType = $annotationReader->getPropertyAnnotations($property);
            $arrayResult[$propName] = $propType[0]->getColumn();
        }
        return $arrayResult;
    }
    public function SQLToObject($class, $result)
    {
        $nsClass = 'Examples\Entity\\' . $class;
        $myClass = new $nsClass();
        $properties = $this->getParamsObjects($class);
        var_dump($properties);
        foreach ($result as $key => $value) {
            foreach ($properties as $keyProp => $property) {
                if ($property === $key) {
                    $func = "set" . ucFirst($keyProp);
                    $myClass->$func($value);
                }
            }
        }
        var_dump($myClass);
    }

    public function findOne($class, $id)
    {
        $table = $this->getTable($class);
        $stmt = $this->connection->prepare("SELECT * FROM " . $table . " WHERE id_film = :id");
        $stmt->execute([':id' => $id]);
        $result = $this->SQLToObject($class, $stmt->fetch());
        return $result;
    }

    public function findAll($class, $id = false, $orderBy = false)
    {
        $stmt = $this->connection->prepare("SELECT * FROM " . $class . " WHERE id_film = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function SQLManager()
    {
        $object = json_decode(json_encode($array), FALSE);
    }
}
