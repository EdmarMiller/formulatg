<?php


namespace App\validate;

use App\models\Connection;


class TablesExist
{
   private $tables = ['cars', 'drivers', 'circuits', 'competition', 'drivers', 'race', 'race_history'];

   public function __construct()
   {
      $this->pdo = (new Connection())->conn();
   }

   public function initialTables() : bool
   {
     foreach ($this->tables as $table) {

         if (!$this->check($table)) {
            return false;
         };
      }
     return true;
   }

   public function check(string $table): bool
   {
      $res = $this->pdo->query("SHOW TABLES LIKE '$table'")->rowCount() > 0;
      return $res;
   }

}