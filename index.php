<?php

use Examples\Entity\Film;
use OtteRM\EntityManager;



require_once 'vendor/autoload.php';

$t = new OtteRM\Annotations\Column(['column' => 'tfchgchgcfhg']);
$t = new OtteRM\Annotations\Table(['name' => 'tfchgchgcfhg']);
$t = new OtteRM\Annotations\Type(['type' => 'tfchgchgcfhg']);

$myTinyManager = new EntityManager();
$myTinyManager->createConnection();
$myTinyManager->updateSchemaDB();
$film = new Film;
// $film->setTitre('My little tiny film');
// $testsam = $myTinyManager->getRepository($film)->findAll();
$testsam2 = $myTinyManager->getRepository($film)->findBy(['titre' => 'home'], ['duration', 'titre']);
// $myTinyManager->getRepository($film)->persist();

var_dump($testsam2);
