<?php
//class principal où on va passer la connection, ainsi que toutes les différentes actions possibles de l'orm
namespace OtteRM;

class EntityManager
{

    private $config;
    private $connection;

    public function __construct()
    { }


    public static function createConnection()
    {
        try {
            $connection = new \PDO('mysql:host=127.0.0.1;dbname=cinema;port=8889', 'root', 'root');
            echo "connect success";
            $this->connection = $connection;
        } catch (\PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }

    public function updateSchemaDB()
    {
        $filesEntities = scandir('src/Entity');
        var_dump($filesEntities);
        array_shift(filesEntities);
        array_shift(filesEntities);
        die;
    }
}
