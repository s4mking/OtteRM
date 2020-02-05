<?php

namespace Examples\DataExample;

use entity\Film;
use entity\Seance;

require_once '../index.php';

$film = $myTinyManager->getRepository($film)->find(1);
$film->setTitle('toto');
$myTinyManager->persist($film);
