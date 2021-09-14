<?php


use App\view\MainMenu;

require __DIR__ . '/../vendor/autoload.php';


$menu = new MainMenu();
echo $menu->run();
exit;






