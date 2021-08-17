<?php

if (!function_exists('message')) {
   function message(string $msg): void
   {
      system('clear');
      echo $msg . PHP_EOL;
   }
}

if (!function_exists('messageSleep')) {
   function messageSleep(string $msg)
   {
      system('clear');
      echo $msg . PHP_EOL;
      sleep('2');
   }
}

if (!function_exists('display')) {
   function display(string $msg): void
   {
      $msg = strtoupper($msg);
      echo $msg . PHP_EOL;
   }
}

if (!function_exists('reload')) {
   function reload(string $route): string
   {
      return $route ;
   }
}