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

   public function checkIfCircuitExists(): bool
   {
      $sql = "SELECT COUNT(*) FROM `circuits`";
      $res = $this->pdo->query($sql);
      $count = $res->fetchColumn();

      if ($count > 0) {
         return true;
      }
      return false;
   }


   public function new(array $data): string
   {
      try {
         $this->insert($data);
         return $this->messageSuccess($data);
      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   private function messageSuccess(array $data): string
   {
      return 'Operação realizada com Sucesso!' . PHP_EOL;
   }


   public function msgDelete(array $data): string
   {
      return 'Gostaria de DELETAR o Carro de ID: ' . $data['id'] .
         ', Marca: ' . $data['circuit'] . ' e Modelo: ' . $data['country'] . PHP_EOL;
   }

   private function insert(array $data): void
   {

      $sql = 'INSERT INTO `circuits`(`circuit` , `country` , `lengthKM` , `totalLaps`) VALUES (?,?,?,?)';
      $this->pdo
         ->prepare($sql)
         ->execute([$data['circuit'], $data['country'], $data['lengthKM'], $data['totalLaps']]);
   }

   public function validate(array $data): bool
   {
      if (strlen($data['circuit']) < 2 || strlen($data['circuit']) >= 50) {
         message('Circuito invalido, Nome precisa ser maior que 2 e menor que 50 caracteres!');
         return false;
      }

      if (strlen($data['country']) < 2 || strlen($data['country']) >= 50) {
         message('Pais inválido! Precisa ser maior que 2 e menor que 50 caracteres!');
         return false;
      }

      if (strlen($data['lengthKM']) < 2 || strlen($data['lengthKM']) >= 10000 || intval($data['lengthKM'] == 0)) {
         message('Quilometros invalidos, é preciso que seja um numeral, maior que 2 e menor que 10000!');
         return false;
      }

      if (strlen($data['totalLaps']) != 3 || intval($data['totalLaps'] == 0)) {
         message('Numero de voltas invalida, e preciso que seja um numeral de até 3 dugotos (999)');
         return false;
      }
      return true;
   }


   public function checkIfIdExist(string $id): bool
   {
      $sql = "SELECT COUNT(*) FROM `circuits` WHERE `id` = '" . $id . "'";
      $res = $this->pdo->query($sql);
      $count = $res->fetchColumn();
      if ($count > 0) {
         return true;
      }
      message('ID não encontrado');
      return false;
   }

   public function info(array $data): string
   {
      return 'Gostaria de editar o ID: ' . $data['id'] .
         ', Marca: ' . $data['circuit'] . ' e Modelo: ' . $data['circuit'] . PHP_EOL;
   }

   public function update(array $data): string
   {
      try {
         $this->updateCircuit($data);
         return $this->messageSuccess($data);
      } catch (\Exception $e) {
         return $e->getMessage();
      }
   }

   public function updateCircuit(array $data): void
   {
      $sql = "UPDATE `circuits` SET `circuit`=?, `country`=?, `lengthKM`=?, `totalLaps`=? WHERE `id`=$data[id]";
      $update = $this->pdo->prepare($sql);
      $update->execute([$data['circuit'], $data['country'], $data['lengthKM'], $data['totalLaps']]);
   }

}
