<?php

namespace App\models;
use PDO;


class Car
{
   public $brand;
   public $model;
   public $color;
   public $yrs;

   private $pdo;

   public function __construct()
   {
      $this->pdo = (new Connection())->conn();
   }

   public function newCar(array $data): string
   {
      try {
         $this->insert($data);
         return $this->messageSuccess($data);
      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   public function info(array $data): string
   {
      return 'Gostaria de editar o ID: ' . $data['id'] .
         ', Marca: ' . $data['brand'] . ' e Modelo: ' . $data['model'] . PHP_EOL;
   }

   public function msgDelete(array $data): string
   {
      return 'Gostaria de DELETAR o Carro de ID: ' . $data['id'] .
         ', Marca: ' . $data['brand'] . ' e Modelo: ' . $data['model'] . PHP_EOL;
   }

   private function insert(array $data): void
   {
      $sql = 'INSERT INTO `cars`(`brand` , `model` , `color` , `yrs`) VALUES (?,?,?,?)';
         $this->pdo
         ->prepare($sql)
         ->execute([$data['brand'], $data['model'], $data['color'], $data['yrs']]);
   }

   public function findAll(): array
   {
      $all = $this->pdo
         ->query("SELECT * FROM `cars` WHERE `status` = 1")
         ->fetchAll(PDO::FETCH_ASSOC);
      return $all;
   }

   public function findAllId(): array
   {
      $all = $this->pdo
         ->query("SELECT `id`, `model` FROM `cars` WHERE `status` = 1")
         ->fetchAll(PDO::FETCH_ASSOC);
      return $all;
   }

   public function findById(int $id): array
   {
      $selectId = $this->pdo
         ->query("SELECT * FROM `cars` WHERE `id` = $id")
         ->fetch(PDO::FETCH_ASSOC);
      return $selectId;
   }

   public function update(array $data): string
   {
      try {
         $this->updateCar($data);
         return $this->messageSuccess($data);
      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   public function updateCar(array $data): void
   {
      $sql = "UPDATE `cars` SET `brand`=?, `model`=?, `color`=?, `yrs`=? WHERE `id`=$data[id]";
      $update = $this->pdo->prepare($sql);
      $update->execute([$data['brand'], $data['model'], $data['color'], $data['yrs']]);
   }

   public function validate(array $data): bool
   {
      if (strlen($data['brand']) < 2 || strlen($data['brand']) >= 50) {
         message('Marca inválida!');
         return false;
      }

      if (strlen($data['model']) < 2 || strlen($data['model']) >= 50) {
         message('Modelo inválido!');
         return false;
      }

      if (strlen($data['color']) < 2 || strlen($data['color']) >= 50) {
         message('Cor inválida!');
         return false;
      }

      if (strlen($data['yrs']) != 4 || intval($data['yrs'] == 0)) {
         message('Ano Inválido');
         return false;
      }

      return $this->checkCarExist($data);
   }

   public function delete(string $id, int $status = 0): void
   {
      $sql = "UPDATE `cars` SET `status`=? WHERE `id`={$id}";
      $del = $this->pdo->prepare($sql);
      $del->execute([$status]);
   }

   public function checkCarExist($data): bool
   {
      $sql = "SELECT COUNT(*) FROM `cars` 
            WHERE `brand` = '" . $data['brand'] . "' 
            AND `model` = '" . $data['model'] . "'  
            AND `color` = '" . $data['color'] . "' 
            AND `yrs` = $data[yrs] 
            AND `status` = 1";
      $res = $this->pdo->query($sql);
      $count = $res->fetchColumn();

      if ($count > 0) {
         message("Carro Já Cadastrado");
         return false;
      }
      return true;
   }

   public function checkIdExist(string $id): bool
   {
      $sql = "SELECT COUNT(*) FROM `cars` WHERE `id` = '" . $id . "'";
      $res = $this->pdo->query($sql);
      $count = $res->fetchColumn();
      if ($count > 0) {
         return true;
      }
      message('ID não encontrado');
      return false;
   }

   private function messageSuccess(array $data)
   {
      return 'Operação realizada com Sucesso!' . PHP_EOL;
   }
}









