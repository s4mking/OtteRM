<?php

use Examples\Entity\Film;
use OtteRM\EntityManager;



require_once 'vendor/autoload.php';

$t = new OtteRM\Annotations\Column(['tfchgchgcfhg']);
$t = new OtteRM\Annotations\Table(['tfchgchgcfhg']);
$t = new OtteRM\Annotations\Type(['tfchgchgcfhg']);
// $t = new OtteRM\config\Column(['tfchgchgcfhg']);
// $t = new OtteRM\config\Type(['tfchgchgcfhg']);
// $t = new OtteRM\config\Table(['tfchgchgcfhg']);

$myTinyManager = new EntityManager();
$myTinyManager->createConnection();
$myTinyManager->updateSchemaDB();
$film = new Film;
$testsam = $myTinyManager->getRepository($film)->findOne(1);
$myTinyManager->getRepository($testsam)->persist();

// var_dump($testsam);


//Que mettre dans votre définition de modèle?
//Comment le structurer?
//Comment le stocker?
//Où le stocker?
