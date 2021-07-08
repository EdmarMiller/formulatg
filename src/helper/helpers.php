<?php

if (!function_exists('message')) {
   function message(string $msg): void
   {
      system("clear");
      echo $msg . PHP_EOL;
   }
}

if (!function_exists('display')) {
   function display(string $msg): void
   {
      $msg = strtoupper($msg);
      echo $msg . PHP_EOL;
   }
}