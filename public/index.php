<?php
header('Content-Type: application/json');

require __DIR__ . DIRECTORY_SEPARATOR . 'src/models/Connection.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'src/controller/Player.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'MenuPrincipal.php';

//$menu = new MenuPrincipal();
//
//$menu->run();

$player = new Player();

$player->newPlayer("Edmar11", "Brasil11");
















