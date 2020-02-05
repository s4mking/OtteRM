<?php

namespace Examples\DataExample;

require_once '../index.php';

$myTinyManager->getRepository($film)->delete(1);
