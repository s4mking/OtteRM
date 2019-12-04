<?php

namespace OtteRM\config;

class ConnectionDb
{


    public static function getConnect()
    {
        try {
            $PDO = new \PDO('mysql:host=localhost;dbname=cinema', 'root', 'root');
            echo "connect success";
            return $PDO;
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }
}
