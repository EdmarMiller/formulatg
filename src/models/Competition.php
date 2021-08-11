<?php


namespace App\models;

use PDO;

class Competition
{
   const STATUS_WAITING = 1;
   const STATUS_IN_PROGRESS = 2;
   const STATUS_FINISHED = 3;
   const STATUS_CANCELED = 4;

   public function __construct()
   {
      $this->pdo = (new Connection())->conn();
   }

   public function insert(array $data): string
   {
      try {
         $sql = "INSERT INTO `competition` (`status`,`circuit_id`,`amount_competitors`) VALUES (?,?,?)";
         $this->pdo
            ->prepare($sql)
            ->execute([$data['status'],$data['circuit_id'],$data['amount_competitors']]);

         $lastId = $this->pdo->lastInsertId();
                  return $lastId;

      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   public function check(string $id)
   {
      $status = $this->pdo
         ->query("SELECT `status` FROM `competition` WHERE `circuit_id` = $id")
         ->fetch(PDO::FETCH_ASSOC);
      return $status;
   }

   public function update(array $data): string
   {
      try {
         $this->updateStatus($data);
         return $this->messageSuccess();
      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   public function updateStatus(array $data): void
   {
      $sql = "UPDATE `competition` SET `status`=? WHERE `id`=$data[competition_id]";
      $update = $this->pdo->prepare($sql);
      $update->execute([$data['status']]);
   }

   private function messageSuccess()
   {
      return 'Alteração de Status bem sucedida!' . PHP_EOL;
   }

   //public function select(int $choice): string
   //{
   //   $status = match ($choice) {
   //      1 => 'WAITING',
   //      2 => 'IN PROGRESS',
   //      3 => 'FINISHED',
   //      default => 'STATUS INDEFINIDO'
   //   };
   //   return $status;
   //}
}