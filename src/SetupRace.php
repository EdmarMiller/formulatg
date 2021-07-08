<?php


namespace App;

use PDO;

class SetupRace
{
   private $pdo;

   public function __construct()
   {
      $this->pdo = (new Connection())->conn();
   }

   public function setupRace()
   {
      system('clear');

      //$this->printTable();
      //exit;
      $prompt = [];
      $prompt[] = $this->setCircuit();
      $prompt[] = $this->setDriver();
      $prompt[] = $this->setCar();
      $prompt[] = $this->setParticipants();

      /*
       id ok
      `date` ok
      id_circuit ok
      id_car
      id_driver

      status

      grid_start
      `position`

      lap
      id_racing
      participants
              */

      print_r($prompt);
      echo " CORRIDA INDISPONIVEL ";
      readLine("Enter");
      return sleep(1) . (new RunMenu())->runMenu();
   }

   private function setCircuit(): array
   {
      $this->printTableCircuit();
      $prompt['id_circuit'] = readLine("Selecione o circuito pelo ID: ");
      return $prompt;
   }

   private function printTableCircuit(): void
   {
      display('CIRCUITOS CADASTRADOS');

      $circuit = new Circuit();
      $array = $circuit->findAll();

      $mask = "|%-3.3s|%-40.40s|%-18.18s|%-6.6s|%-3.3s|" . PHP_EOL;
      printf($mask, 'ID', 'NOME', 'PAIS', 'KM', ' VOLTAS');

      foreach ($array as $circuit) {
         printf($mask, $circuit['id'], $circuit['circuit'], $circuit['country'], $circuit['lengthKM'], $circuit['totalLaps']);
      }
   }

   public function setDriver(): array
   {
      $this->printTableDriver();
      $prompt['id_drive'] = readLine("Selecione seu Piloto pelo ID: ");
      return $prompt;
   }

   private function printTableDriver(): void
   {
      display('PILOTOS CADASTRADOS');
      $driver = new Driver();
      $array = $driver->findAll();

      $mask = "|%-3.3s|%-12.12s|%-12.12s|" . PHP_EOL;
      printf($mask, 'ID', 'NOME', 'PAIS');

      foreach ($array as $driver) {
         printf($mask, $driver['id'], $driver['name'], $driver['country']);
      }
   }

   public function setCar(): array
   {
      $this->printTableCar();
      $prompt['id_car'] = readLine("Selecione seu Car pelo ID: ");
      return $prompt;
   }

   private function printTableCar(): void
   {
      display('CARROS CADASTRADOS');
      $car = new Car();
      $array = $car->findAll();

      $mask = "|%-3.3s|%-12.12s|%-12.12s|%-12.12s|%-12.12s|" . PHP_EOL;
      printf($mask, 'ID', 'MARCA', 'MODELO', 'COR', 'ANO');

      foreach ($array as $car) {
         printf($mask, $car['id'], $car['brand'], $car['model'], $car['color'], $car['yrs']);
      }

   }

   public function setParticipants(): array
   {
      $d = new Driver();
      $numMaxOfParticipantsPermittion = $d->numberAllDrivers();
      $numMinOfParticipantsPermittion = 2;
      message("Numero máximo de corredores permitidos é: {$numMaxOfParticipantsPermittion}");
      $prompt['participants'] = readLine("digite o numero de corredores: ");

      if ($prompt['participants'] > $numMaxOfParticipantsPermittion || $prompt['participants'] < $numMinOfParticipantsPermittion) {
         message('Numero de participantes invalido');
         return $this->setParticipants();
      }
      return $prompt;
   }

   public function setStatus(): array
   {
      echo "set Status \n";
      $prompt['status'] = readLine("Selecione seu Car pelo ID: ");
      return $prompt;
   }

   public function printTable(): void
   {

      for ($i = 1; $i <= 100; $i++) {
         $p = new Driver();
         $array = $p->findAll();
         foreach ($array as $drive) {
            echo $drive['id'];
            echo " ";
         }
         echo "\n";
         shuffle($array);
         //print_r($array);
         foreach ($array as $drive) {
            echo $drive['id'];
            echo " ";
         }
         echo "\n";
         foreach ($array as $drive => $value) {
            $drive++;
            echo $drive;
            echo " ";
         }
         echo "\n----------------------------------------\n";
      }
   }
}

//   // TODO Acho legal guardar o historico das corridas e ultrapassagens.
//
//
//
//   // Escolher piloto -> block nas escolhas
//   // Escolher carro -> block nas escolhas

//   // sortear as positions do grind
//   // imprimir as posiçoes iniciais setar Grid na tabela racing
//
//   // colocar iniciar corrida...setar InProgress e habilitar ultrapasagem...
//   // pensar em como contar as voltas... tlv 1 por segundo
//
//   // finaliza quando o tempo acaba ou quando aperta em finalizar
//
//   // mostra as posiçoes finais, tentando dar enfase as 3 primeiras...
//   // pergunta se gostaria de ver o historico de ultrapassagem
//

//}
