<?php


namespace App;


use PDO;

class Circuit
{
   public function __construct()
   {
      $this->pdo = (new Connection())->conn();
   }

   public function findAll(): array
   {
      $all = $this->pdo->query("SELECT * FROM circuits")->fetchAll(PDO::FETCH_ASSOC);
      return $all;
   }

   public function findById(int $id): array
   {
      $selectId = $this->pdo->query("SELECT * FROM circuits WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
      return $selectId;
   }

}