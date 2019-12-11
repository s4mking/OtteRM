<?php
//class principal où on va passer la connection, ainsi que toutes les différentes actions possibles de l'orm
namespace OtteRM;

use ReflectionClass;

use Examples\Entity as Entity;
use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionProperty;
use Symfony\Component\Yaml\Yaml;
use OtteRM\config\LoggedPDO;
use OtteRM\config\LoggedPDOStatement;
use OtteRM\config\Translator;

class EntityManager
{

    private $config;
    private $connection;
    private $annotationReader;
    private $translator;


    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();
        $this->translator = new Translator;
    }


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
            $connection = new LoggedPDO('mysql:host=' . $connectionParams['host'] . ';dbname=' . $connectionParams['dbname'] . ';port=' . $connectionParams['port'], $connectionParams['user'], $connectionParams['password']);
            echo "connect success";
            $this->connection = $connection;
        } catch (\PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }
    public function getRepository($object)
    {
        $className = (new \ReflectionClass($object))->getShortName();
        $arrayName = preg_split("/\\\\/", $className);
        $repositoryNamespace = 'src/Repository/' . $arrayName[0] . 'Repository.php';
        if (file_exists($repositoryNamespace)) {
            $className = str_replace('.php', '', $repositoryNamespace);
            $className = str_replace('/', '\\', $className);
            $className = str_replace('src', 'OtteRM', $className);
            return (new $className($this->connection, $this->getTable($object), $this->getIdSql($object), $this->translator->getParamsObjects($object), $object));
        }
    }


    public function updateSchemaDB()
    {
        $entityFiles = scandir('Examples/Entity');
        array_shift($entityFiles);
        array_shift($entityFiles);
        foreach ($entityFiles as $entity) {
            $entity = str_replace(".php", "", $entity);
            $reflClass = new ReflectionClass('Examples\Entity\\' . $entity);
            $classAnnotations = $this->annotationReader->getClassAnnotations($reflClass);
            $props = $reflClass->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC);
            foreach ($props as $prop) {
                $propName = ($prop->name);
                $property = new ReflectionProperty('Examples\Entity\\' . $entity, $propName);
                $propType = $this->annotationReader->getPropertyAnnotations($property);
            }
        }
    }
    public function getTable($object)
    {
        $reflClass = new ReflectionClass(get_class($object));
        $classAnnotations = $this->annotationReader->getClassAnnotations($reflClass);
        return $classAnnotations[0]->getName();
    }
    public function getIdSql($object)
    {
        $reflClass = new ReflectionClass(get_class($object));
        $props = $reflClass->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            $propName = ($prop->name);
            if ($propName === 'id' || $propName === 'id' . get_class($object) || $propName === 'id' . ucfirst($propName)) {
                $property = new ReflectionProperty(get_class($object), $propName);
                $idDatabase = $this->annotationReader->getPropertyAnnotations($property);
                return $idDatabase[0]->getColumn();
            }
        }
    }
}
