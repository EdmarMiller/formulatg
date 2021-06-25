<?php

class Player
{
   private $name;
   private $country;
   public $points;

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

   //Todo Verifica se ja existe, aqui em outros itens de consultas.
   public function newPlayer($name, $country)
   {
      $sql = 'INSERT INTO players(name , country) VALUES (?,?)';
      $this->pdo->prepare($sql)->execute([$name, $country]);
   }

   // TODO os pontos vem de outras class, verificar como faz?
   public function getPoints()
   {
      return $this->points;
   }

   public function setPoints($points): void
   {

   }

   // TODO mesmo caso de cima
   public function info()
   {
      echo "My name is {$this->name} and my country {$this->country} your points: {$this->points}";
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

   public function update(int $id, string $name, string $country): void
   {
      $sql = "UPDATE players SET name=?, country=? WHERE id=$id";
      $update = $this->pdo->prepare($sql);
      $update->execute([$name, $country]);
   }


// Setamos para 0 players "Deletados"
   public function delete($id, $status = 0): void
   {
      $sql = "UPDATE players SET status=? WHERE id=$id";
      $del = $this->pdo->prepare($sql);
      $del->execute([$status]);

   }


}





