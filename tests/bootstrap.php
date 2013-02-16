<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__  . '/BaseTestCase.php';

$configurator = new Nette\Config\Configurator();

$configurator->setDebugMode(TRUE);
$configurator->enableDebugger();

$configurator->setTempDirectory(__DIR__ . '/temp');

$configurator->addConfig(__DIR__ . '/config/config.neon', FALSE);
$configurator->addConfig(__DIR__ . '/config/config.local.neon', FALSE);
$container = $configurator->createContainer();