<?php

namespace App\models;

use Exception;
use PDO;

class Driver
{
   private $name;
   private $country;
   private $status;

   private $pdo;

   public function __construct()
   {
      $this->pdo = (new Connection())->conn();
   }

   public function getName(): string
   {
      return $this->name;
   }

   public function setName($name): void
   {
      $this->name = $name;
   }

   public function newDriver(array $data): string
   {
      try {
         $this->insertDrive($data);
         return $this->messageSuccess($data);
      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   public function info(array $data): string
   {
      return 'Gostaria de editar o ID: ' . $data['id'] .
         ', Nome: ' . $data['name'] . ' , e País: ' . $data['country'] . PHP_EOL;
   }

   private function messageSuccess(array $data): string
   {
      return 'Olá, ' . $data['name'] . ' do ' . $data['country'] .
         ', Operação realizada com Sucesso!' . PHP_EOL;
   }

   private function insertDrive(array $data): void
   {
      $sql = 'INSERT INTO drivers(name , country) VALUES (?,?)';
      $this->pdo->prepare($sql)
         ->execute([$data['name'], $data['country']]);
   }

   public function findAll(): array
   {
      $all = $this->pdo
         ->query("SELECT * FROM `drivers` WHERE `status` = 1")
         ->fetchAll(PDO::FETCH_ASSOC);
      return $all;
   }

   public function findAllId(): array
   {
      $all = $this->pdo
         ->query("SELECT `id`, `name` FROM `drivers` WHERE `status` = 1")
         ->fetchAll(PDO::FETCH_ASSOC);
      return $all;
   }

   public function findAllAdversaries($id, $participants): array
   {
      $all = $this->pdo
         ->query("SELECT `id`, `name` FROM `drivers` WHERE `status` = 1 AND id <> $id LIMIT $participants")
         ->fetchAll(PDO::FETCH_ASSOC);
      return $all;
   }

   public function findAllDrivers($id, $participants): array
   {
      $all = $this->pdo
         ->query("SELECT `id`, `name` FROM `drivers` WHERE `status` = 1 AND id <> $id LIMIT $participants")
         ->fetchAll(PDO::FETCH_ASSOC);
      return $all;
   }

   public function findById(int $id): array
   {
      $selectId = $this->pdo
         ->query("SELECT * FROM `drivers` WHERE `id` = $id")
         ->fetch(PDO::FETCH_ASSOC);
      return $selectId;
   }

   public function update(array $data): string
   {
      try {
         $this->updateDrive($data);
         return $this->messageSuccess($data);
      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   public function updateDrive(array $data): void
   {
      $sql = "UPDATE `drivers` SET `name`=?, `country`=? WHERE `id`=$data[id]";
      $update = $this->pdo->prepare($sql);
      $update->execute([$data['name'], $data['country']]);
   }

   public function delete(string $id, int $status = 0): void
   {
      $sql = "UPDATE `drivers` SET `status`=? WHERE `id`=$id";
      $del = $this->pdo->prepare($sql);
      $del->execute([$status]);
   }

   public function validate(array $data): bool
   {
      if (strlen($data['name']) < 3 || strlen($data['name']) >= 50) {
         message('Nome inválido!');
         return false;
      }

      if (strlen($data['country']) < 3 || strlen($data['country']) >= 50) {
         message('Pais inválido!');
         return false;
      }

      return $this->checkNameExist($data['name']);
   }

   private function checkNameExist(string $name): bool
   {
      $sql = "SELECT COUNT(*) FROM `drivers` WHERE `name` = '" . $name . "'";
      $res = $this->pdo->query($sql);
      $count = $res->fetchColumn();

      if ($count > 0) {
         message('Usuario já Cadastrado');
         return false;
      }

      return true;
   }

   public function checkIfIdExists(string $id): bool
   {
      $sql = "SELECT COUNT(*) FROM `drivers` WHERE `id` = '" . $id . "'";
      $res = $this->pdo->query($sql);
      $count = $res->fetchColumn();
      if ($count > 0) {
         return true;
      }
      message('ID não encontrado');
      return false;
   }

   public function numberAllDrivers(): int
   {
      $sql = "SELECT COUNT(*) FROM `drivers` WHERE `status` = 1";
      $res = $this->pdo->query($sql);
      $count = $res->fetchColumn();
      return $count;
   }

}





