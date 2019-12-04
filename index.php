<?php

require_once 'vendor/autoload.php';

use OtteRM\EntityManager;

$myTinyManager = new EntityManager();
$myTinyManager->createConnection();
$myTinyManager->updateSchemaDB();

//Que mettre dans votre définition de modèle?
//Comment le structurer?
//Comment le stocker?
//Où le stocker?
