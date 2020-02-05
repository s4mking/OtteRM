<?php

namespace Examples\DataExample;

use entity\Film;

require_once '../index.php';

$filmRepository = $myTinyManager->getRepository(Film::class);

$film =  $myTinyManager->getRepository($film)->find(1);

$allFilms = $myTinyManager->getRepository($film)->findAll();

$filmFindBy = $myTinyManager->getRepository($film)->findBy(['titre' => 'home'], ['duration', 'titre']);

$countTitle = $myTinyManager->getRepository($film)->findBy(['titre' => 'home'], ['duration', 'titre'], 'titre');


var_dump($film, $allFilms, $filmFindBy, $countTitle);
