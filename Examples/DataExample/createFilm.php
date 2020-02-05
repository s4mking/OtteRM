<?php

namespace Examples\DataExample;

use Examples\Entity\Film;

require_once '../index.php';

$film = new Film;
$film->setDateDebut(new \DateTime());
$film->setTitre('same title');
$film->setDuration(123);
$film->setDirector('me');

$myTinyManager->persist($film);
