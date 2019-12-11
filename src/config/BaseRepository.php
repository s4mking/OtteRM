<?php

namespace OtteRM\config;

class BaseRepository
{
    public $con;
    public $table;
    public $idClass;
    public $properties;
    public $object;
    public $translator;

    public function __construct($con, $table, $idClass, $properties, $object)
    {
        $this->con = $con;
        $this->table = $table;
        $this->idClass = $idClass;
        $this->properties = $properties;
        $this->object = $object;
        $this->translator = new Translator;
    }

    public function findOne($id)
    {
        $stmt = $this->con->prepare("SELECT * FROM " . $this->table . " WHERE " . $this->idClass . " = :id");
        $stmt->execute([':id' => $id]);
        $result = $this->SQLToObject($stmt->fetchAll());
        return $result[0];
    }

    public function findAll()
    {
        $stmt = $this->con->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        $result = $this->SQLToObject($stmt->fetchAll());
        return $result;
    }

    public function findBy($findParams, $orderParam = [])
    {
        $conditions = '';
        $first = true;

        foreach ($findParams as $key => $value) {
            if ($first) {
                $first = false;
            } else {
                $conditions .= ' AND ';
            }
            $conditions .= '`' . $this->table . '`.`' . $key . '` = \'' . $value . '\'';
        }
        if (!empty($conditions)) {
            $stmt = $this->con->prepare("SELECT * FROM " . $this->table . " WHERE " . $conditions);
        } else {
            $stmt = $this->con->prepare("SELECT * FROM " . $this->table);
        }
        $stmt->execute();
        $result = $this->SQLToObject($stmt->fetchAll());
        return $result;
    }

    public function delete($id)
    {
        $stmt = $this->con->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->idClass . " = :id");
        $stmt->execute([':id' => $id]);
    }

    public function persist()
    {
        if ($this->exist()) {
            var_dump('find');
            // $stmt = $this->con->prepare('UPDATE ' . $this->table . ' SET(' .. " = :id");

        } else {
            // $stmt = $this->con->prepare('INSERT INTO ' . $this->table . ' VALUES('  " = :id");
        }
    }

    public function exist()
    {
        return  !is_null($this->findOne($this->object->getId())) ? true : false;
    }

    public function SQLToObject($results)
    {
        $nsClass = get_class($this->object);
        $objects = array();
        foreach ($results as $result) {
            $myClass = new $nsClass();
            foreach ($result as $key => $value) {
                foreach ($this->properties as $keyProp => $property) {
                    if ($property[0] === $key) {
                        switch ($property[1]) {
                            case "string":

                                break;
                            case "int":
                                $value = (int) $value;
                                break;
                            case "date":
                                $value = new \DateTime($value);

                                break;
                            case "relation":
                                //A voir omment riater
                                break;
                        }
                        $func = "set" . ucFirst($keyProp);
                        $myClass->$func($value);
                    }
                }
            }
            if (count($results) < 1) {
                return $myClass;
            }
            $objects[] = $myClass;
        }
        return $objects;
    }
}
