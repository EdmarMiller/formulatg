<?php


namespace App\models;


use PDO;

class RaceHistory
{
   public function __construct()
   {
      $this->pdo = (new Connection())->conn();
   }

   public function insert(array $data): string
   {
      try {
         $sql = 'INSERT INTO `race_history` (
                          `race_id`, 
                          `driver_win_position`, 
                          `driver_loss_position`, 
                          `position_of`, 
                          `position_to`) VALUES (?, ?, ?, ?, ?)';
         $this->pdo
            ->prepare($sql)
            ->execute($data);

         return $this->messageSuccess();
      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   public function checkIfIdExists(string $id): bool
   {
      $sql = "SELECT COUNT(*) FROM `race_history` WHERE `race_id` = '" . $id . "'";
      $res = $this->pdo->query($sql);
      $count = $res->fetchColumn();
      if ($count > 0) {
         return true;
      }
      message('ID não encontrado');
      return false;
   }

   public function findAll(string $id): array
   {
      $all = $this->pdo
         ->query("SELECT * FROM `race_history` WHERE `race_id` = '" . $id . "'")
         ->fetchAll(PDO::FETCH_ASSOC);
      return $all;
   }

   private function messageSuccess()
   {
      return 'Alteração de Status bem sucedida!' . PHP_EOL;
   }
}