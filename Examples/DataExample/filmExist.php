<?php

namespace Examples\DataExample;

use Examples\Entity\Film;

require_once '../index.php';

$testsam = $myTinyManager->getRepository($film)->exist(9);

var_dump($testsam);
