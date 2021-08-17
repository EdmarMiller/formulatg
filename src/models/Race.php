<?php


namespace App\models;


use PDO;

class Race
{

   public function __construct()
   {
      $this->pdo = (new Connection())->conn();
   }

   public function insertRace(string $competitionId, array $competitors): string
   {
      try {
         $sql = 'INSERT INTO `race` (
                        `competition_id`, 
                        `driver_id`, 
                        `car_id`, 
                        `position`) VALUES';

         foreach ($competitors as $key => $competitor) {
            $position = $key + 1;
            $sql .= " ($competitionId,{$competitor['driver_id']},{$competitor['car_id']},{$position}) ,";
         }

         $sql = rtrim($sql, ',');
         $this->pdo
            ->prepare($sql)
            ->execute();

         return $this->messageSuccess();
      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   public function find($competitionId): array
   {
      $all = $this->pdo
         ->query("SELECT drivers. id, drivers.name, cars.model, race.`position` 
            FROM race
            INNER JOIN drivers ON race.driver_id = drivers.id
            INNER JOIN cars ON race.car_id = cars.id
            WHERE race.competition_id = $competitionId
            ORDER BY race.`position`; ")
         ->fetchAll(PDO::FETCH_ASSOC);
      return $all;
   }

   public function findMainDriver($competitionId, $idMainDriver): array
   {
      $all = $this->pdo
         ->query("SELECT drivers. id, drivers.name, cars.model, race.`position` 
            FROM race
            INNER JOIN drivers ON race.driver_id = drivers.id
            INNER JOIN cars ON race.car_id = cars.id
            WHERE race.competition_id = $competitionId AND drivers.id = $idMainDriver; ")
         ->fetch(PDO::FETCH_ASSOC);
      return $all;
   }

   public function findById(int $competitionId): array
   {
      $selectId = $this->pdo
         ->query("SELECT * FROM race WHERE competition_id = '" . $competitionId . "'")
         ->fetch(PDO::FETCH_ASSOC);
      return $selectId;
   }

   public function update(array $data): string
   {
      try {
         $this->updatePosition($data);
         return $this->messageSuccess();
      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   public function updatePosition(array $data): void
   {
      $sql = "UPDATE race SET `position`=? WHERE driver_id=$data[driver_id]";
      $update = $this->pdo->prepare($sql);
      $update->execute([$data['position']]);
   }

   private function messageSuccess()
   {
      return 'Alteração de Status bem sucedida!' . PHP_EOL;
   }




}