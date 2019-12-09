<?php

use Examples\Entity\Film;
use OtteRM\EntityManager;



require_once 'vendor/autoload.php';

$t = new OtteRM\Annotations\Column(['tfchgchgcfhg']);
$t = new OtteRM\Annotations\Table(['tfchgchgcfhg']);
$t = new OtteRM\Annotations\Type(['tfchgchgcfhg']);

$myTinyManager = new EntityManager();
$myTinyManager->createConnection();
$myTinyManager->updateSchemaDB();
$testsam = $myTinyManager->findOne('Film', 1);
// var_dump($testsam);


//Que mettre dans votre définition de modèle?
//Comment le structurer?
//Comment le stocker?
//Où le stocker?
