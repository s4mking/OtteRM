<?php

namespace OtteRM\config;

use ReflectionObject;

class BaseRepository
{
    public $con;
    public $table;
    public $idClass;
    public $properties;
    public $object;
    public $translator;
    public $logger;

    public function __construct($con, $table, $idClass, $properties, $object)
    {
        $this->con = $con;
        $this->table = $table;
        $this->idClass = $idClass;
        $this->properties = $properties;
        $this->object = $object;
        $this->translator = new Translator;
        $this->logger = new LogWriter;
    }

    public function findOne($id)
    {
        $stmt = $this->con->prepare("SELECT * FROM " . $this->table . " WHERE " . $this->idClass . " = :id");
        $stmt->execute([':id' => $id]);
        $result = $this->SQLToObject($stmt->fetchAll());
        if (!empty($result)) {
            return $result[0];
        } else {
            $this->logger->writeLogError("No records found");
        }
    }

    public function findAll()
    {
        $stmt = $this->con->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        $result = $this->SQLToObject($stmt->fetchAll());
        if (!empty($result)) {
            return $result;
        } else {
            $this->logger->writeLogError("No records found");
        }
    }

    public function findBy($findParams, $orderBy = [])
    {
        $conditions = '';
        $first = true;
        $arrayFields = ($this->translator->mapperToSqlColumn($findParams, $this->object));
        $arrayOrderBy = ($this->translator->mapperToSqlColumn($orderBy, $this->object));
        foreach ($arrayFields as $key => $value) {
            if ($first) {
                $first = false;
            } else {
                $conditions .= ' AND ';
            }
            $conditions .= '' . $this->table . '.' . $key . ' LIKE \'%' . $value . '%\'';
        }

        if (!empty($orderBy)) {
            $str = "";
            $first = true;
            foreach ($orderBy as $order) {
                if ($first) {
                    $first = false;
                } else {
                    $str .= ' , ';
                }
                $str .= $this->translator->mapperSingleValueColumn($order, $this->object);
            }
            if (!empty($conditions)) {
                $stmt = $this->con->prepare("SELECT * FROM " . $this->table . " WHERE " . $conditions . " ORDER BY " . $str);
            } else {
                $stmt = $this->con->prepare("SELECT * FROM " . $this->table . " ORDER BY " . $str);
            }
        } else {
            if (!empty($conditions)) {
                $stmt = $this->con->prepare("SELECT * FROM " . $this->table . " WHERE " . $conditions);
            } else {
                $stmt = $this->con->prepare("SELECT * FROM " . $this->table);
            }
        }

        $str = $orderBy[0];

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
        var_dump($this->object);
        $dataFormat = $this->ObjectToSql($this->object);
        $valuesRequest = "";

        foreach ($dataFormat as $key => $data) {
            if ($key === "id") {
                $idTable = $key;
            } else {
                if ($key === array_key_last($dataFormat)) {
                    $valuesRequest .= $key . " = '" . $data . " ' ";
                } else {
                    $valuesRequest .= $key . " = ' "  . $data . " '  , ";
                }
            }
        }

        if ($this->exist()) {

            $stmt = $this->con->prepare('UPDATE ' . $this->table . ' SET(' . $dataFormat . ') WHERE = :id ');
            $stmt->execute([':id' => $idTable]);
        } else {

            function format($n)
            {
                return ("'" . $n . "',");
            }
            unset($dataFormat['id_distributeur']);
            unset($dataFormat['id']);
            $columns = array_keys($dataFormat);
            $columnsExplode = implode(",", $columns);
            $strValues = "";
            foreach ($dataFormat as $key => $val) {
                if ($key === array_key_last($dataFormat)) {
                    $strValues .= "'" . addslashes($val) . "'";
                } else {
                    $strValues .= "'" . addslashes($val) . "',";
                }
            }
            $stmt = $this->con->query('INSERT INTO ' . $this->table . '(' . $columnsExplode . ' ) VALUES(' . $strValues . ')');
            // $stmt = $this->con->query("INSERT INTO films(titre,resum,date_debut_affiche,date_fin_affiche,duree_minutes,annee_production,id_distributeur) VALUES('Son altesse samuel','Based on Nicholas Pileggi's book Wiseguy this is a film about the life of Henry Hill, an aspiring criminal who ends up in the FBIs witness protection program after testifying against his former partners.','1990-01-01','1990-02-12','146','1990')");
        }
    }

    public function exist()
    {
        return  is_null($this->findOne($this->object->getId())) ? true : false;
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
    public function ObjectToSql($results)
    {
        $arrayMapping = $this->translator->getParamsObjects($results);
        $arraySql = [];
        foreach ($arrayMapping as $key => $row) {
            $getter = "get" . ucFirst($key);
            $value = $this->object->$getter();
            if ($row[1] === "date" && !is_null($value)) {
                $o = new ReflectionObject($value);
                $p = $o->getProperty('date');
                $date = $p->getValue($value);
                $value = date('Y-m-d', strtotime($date));
            }
            if ($key === 'id') {
                $arraySql['id'] = $value;
            } else {
                $arraySql[$row[0]] = $value;
            }
        }
        return $arraySql;
    }
}
