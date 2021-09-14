<?php


namespace App\models;

class CreateTables
{
   public function __construct()
   {
      $this->pdo = (new Connection())->conn();
   }

   public function createAll()
   {
      $this->cars();
      $this->circuits();
      $this->competition();
      $this->drivers();
      $this->race();
      $this->raceHistory();
   }

   private function cars(): void
   {
      $sql = "CREATE TABLE IF NOT EXISTS `cars` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `brand` varchar(30) NOT NULL,
        `model` varchar(50) NOT NULL,
        `color` varchar(20) NOT NULL,
        `yrs` int(4) NOT NULL,
        `status` smallint(6) NOT NULL DEFAULT 1,
         PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4";

      $this->pdo->exec($sql);
   }

   private function circuits(): void
   {
      $sql = "CREATE TABLE IF NOT EXISTS `circuits` (
         `id` int(11) NOT NULL AUTO_INCREMENT,
         `circuit` varchar(50) NOT NULL,
         `country` varchar(50) NOT NULL,
         `lengthKM` int(10) NOT NULL DEFAULT 60,
         `totalLaps` int(11) NOT NULL,
         `status` smallint(6) NOT NULL DEFAULT 1,
         PRIMARY KEY (`id`)
        )ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4";

      $this->pdo->exec($sql);
   }

   private function competition(): void
   {
      $sql = "CREATE TABLE IF NOT EXISTS `competition` (
         `id` int(11) NOT NULL AUTO_INCREMENT,
         `date` date DEFAULT current_timestamp(),
          `status` int(11) DEFAULT NULL,
         `circuit_id` int(11) DEFAULT NULL,
          `amount_competitors` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`),
         KEY `competition_FK_circuits` (`circuit_id`),
         CONSTRAINT `competition_FK_circuits` FOREIGN KEY (`circuit_id`) REFERENCES `circuits` (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4";

      $this->pdo->exec($sql);
   }

   private function drivers(): void
   {
      $sql = "CREATE TABLE IF NOT EXISTS `drivers` (
         `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(50) NOT NULL,
         `country` varchar(50) NOT NULL,
         `status` int(11) DEFAULT 1,
          PRIMARY KEY (`id`),
          UNIQUE KEY `drivers_UN` (`name`)
        ) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4";

      $this->pdo->exec($sql);
   }

   private function race(): void
   {
      $sql = "CREATE TABLE IF NOT EXISTS `race` (
         `id` int(11) NOT NULL AUTO_INCREMENT,
          `date` date DEFAULT current_timestamp(),
          `competition_id` int(11) DEFAULT NULL,
          `driver_id` int(11) DEFAULT NULL,
          `car_id` int(11) DEFAULT NULL,
          `position` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `race_car` (`car_id`),
          KEY `race_driver` (`driver_id`),
          KEY `race_FK` (`competition_id`),
          CONSTRAINT `race_FK` FOREIGN KEY (`competition_id`) REFERENCES `competition` (`id`),
          CONSTRAINT `race_car` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
          CONSTRAINT `race_driver` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4";

      $this->pdo->exec($sql);
   }

   private function raceHistory(): void
   {
      $sql = "CREATE TABLE IF NOT EXISTS`race_history` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
     `race_id` int(11) DEFAULT NULL,
     `time` timestamp NULL DEFAULT curtime(),
     `driver_win_position` int(11) DEFAULT NULL,
     `driver_loss_position` int(11) DEFAULT NULL,
     `position_of` int(11) DEFAULT NULL,
     `position_to` int(11) DEFAULT NULL,
     PRIMARY KEY (`id`),
     KEY `race_history_FK` (`race_id`),
     CONSTRAINT `race_history_FK` FOREIGN KEY (`race_id`) REFERENCES `competition` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

      $this->pdo->exec($sql);
   }
}