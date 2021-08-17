<?php

namespace App\models;
use PDO;

class Circuit
{
   public function __construct()
   {
      $this->pdo = (new Connection())->conn();
   }

   public function findAll(): array
   {
      $all = $this->pdo->query("SELECT * FROM `circuits`")->fetchAll(PDO::FETCH_ASSOC);
      return $all;
   }

   public function findById(int $id): array
   {
      $selectId = $this->pdo->query("SELECT * FROM `circuits` WHERE `id` = $id")->fetch(PDO::FETCH_ASSOC);
      return $selectId;
   }

   public function findLapsById($id): array
   {
      $selectId = $this->pdo->query("SELECT `id`, `totalLaps` FROM `circuits` WHERE `id` = $id")
         ->fetch(PDO::FETCH_ASSOC);
      return $selectId;
   }

   public function checkIfIdExists(string $id): bool
   {
      $sql = "SELECT COUNT(*) FROM `circuits` WHERE `id` = '" . $id . "'";
      $res = $this->pdo->query($sql);
      $count = $res->fetchColumn();

      if ($count > 0) {
         return true;
      }
      message('Digite um Id Valido!');
      return false;
   }


}