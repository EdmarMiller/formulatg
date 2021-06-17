<?php

class Player
{
   private $name;
   private $country;
   private $points;

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

   public function getCountry(): string
   {
      return $this->country;
   }

   public function setCountry($country): void
   {
      $this->country = $country;
   }
   //Todo Insere duplicado
   //public function newPlayer(string $name, string $country)
   //{
   //   $sql = 'INSERT INTO players( name, country) VALUES (?,?)';
   //   $addCar = $this->pdo->prepare($sql);
   //   $addCar->bindValue(1, $name);
   //   $addCar->bindValue(2, $country);
   //   $addCar->execute();
   //   $this->pdo = null;
   //}
//Todo Insere duplicado
   public function newPlayer(string $name, string $country)
   {

      $sql = 'INSERT INTO players(name , country) VALUES (?,?)';
      $po = $this->pdo->prepare($sql);
      $po->execute([$name, $country]);
      echo $this->pdo->lastInsertId();
      exit;

   }
//   public function newPlayer()
//   {
//      $sql = 'INSERT INTO players(name , country) VALUES (?,?)';
//      $this->pdo->prepare($sql)->execute([$name, $country]);
//   }





   public function getPoints()
   {
      return $this->points;
   }

   public function setPoints($points): void
   {
      //TODO Ver Como pegar as infos dos pontos, qual relacionamento a class vai ter, Agregação, Asociação...
   }

   // TODO Trazer info como numeros de vitorias, pole... e mais
   public function info()
   {
      echo "My name is {$this->name} and my country {$this->country}";
   }

   public function find(): array
   {
      $all = $this->pdo->query("SELECT * FROM players")->fetchAll(PDO::FETCH_ASSOC);
      return $all;
   }

   public function findById(int $id): array
   {
      $selectId = $this->pdo->query("SELECT * FROM players WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
      return $selectId;
   }

   public function update(int $id, string $name, string $country):void
   {
      $sql = "UPDATE players SET name=?, country=? WHERE id=$id";
      $update = $this->pdo->prepare($sql);
      $update->execute([$name, $country]);
   }

// todo Criar status no DB e setar 0 quando não ativo e 1 quando ativo ou false e true
   public function delete(int $id):void
   {
      $sql = "DELETE FROM players WHERE id=$id";
      $update = $this->pdo->prepare($sql);
      $update->execute([$id]);
   }

   //public function delete(int $id):void
   //{
   //   $sql = "DELETE FROM players WHERE id=$id";
   //   $update = $this->pdo->prepare($sql);
   //   $update->execute([$id]);
   //}


}





