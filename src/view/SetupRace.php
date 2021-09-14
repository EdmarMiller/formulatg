<?php


namespace App\view;

use App\models\Car;
use App\models\Circuit;
use App\models\Competition;
use App\models\Driver;
use App\models\Race;


class SetupRace
{

   public function setupRace(): string
   {
      system('clear');

      $prompt = [];
      $prompt = array_merge($prompt, $this->chooseCircuit());
      $prompt = array_merge($prompt, $this->chooseMainDriver());
      $prompt = array_merge($prompt, $this->chooseMainCar());
      $prompt = array_merge($prompt, $this->setAmountCompetitors());

      $prompt = array_merge($prompt, $this->setWaitingCompetition($prompt));
      $prompt = array_merge($prompt, $this->setCompetitors($prompt));

      $race = new GridMenu();
      $race->gridMenu($prompt);

      return sleep(1) . (new RunMenu())->runMenu();
   }

   private function chooseCircuit(): array|string
   {

      $circuit = new Circuit();

      if (!$circuit->checkIfCircuitExists()) {
         readLine('NAO EXISTE CIRCUITO, CLICK E SERA DIRECIONADO PARA O CADASTRO. ');
         return (new CircuitMenu())->circuitMenu();
      }

      $this->printTableCircuits();

      $id = $prompt['circuit_id'] = readLine('Selecione o circuito pelo ID: ');
      if ($circuit->checkIfIdExists($id)) {
         // $prompt['totalLaps'] = ($circuit->findLapsById($id)['totalLaps']);
         return $prompt;
      }

      return $this->chooseCircuit();
   }

   private function printTableCircuits(): void
   {
      system('clear');
      display('CIRCUITOS CADASTRADOS');

      $circuit = new Circuit();
      $array = $circuit->findAll();

      $mask = "|%-3.3s|%-40.40s|%-16.16s|%-6.6s|%-6.6s|" . PHP_EOL;
      printf($mask, 'ID', 'NOME', 'PAIS', 'KM', 'VOLTAS');

      foreach ($array as $circuit) {
         printf($mask, $circuit['id'], $circuit['circuit'], $circuit['country'], $circuit['lengthKM'], $circuit['totalLaps']);
      }
   }

   private function chooseMainDriver(): array | string
   {
      $car = new Driver();
      if (!$car->checkIfMinDriverExists()) {
         readLine('E PRECISO QUE TENHA 2 PILOTOS CADSTRADOS, APERTE E SERA DIRECIONADO PARA O CADASTRO. ');
         return (new DriverMenu())->driverMenu();
      }

      $this->printTableDrivers();
      $id = $prompt['driver_id'] = readLine('Selecione o piloto principal pelo ID: ');

      $driver = new Driver();
      if ($driver->checkIfIdExists($id)) {
         return $prompt;
      }
      sleep(1);
      return $this->chooseMainDriver();
   }

   private function printTableDrivers(): void
   {
      system('clear');
      display('PILOTOS CADASTRADOS');
      $driver = new Driver();
      $array = $driver->findAll();

      $mask = "|%-3.3s|%-12.12s|%-12.12s|" . PHP_EOL;
      printf($mask, 'ID', 'NOME', 'PAIS');

      foreach ($array as $driver) {
         printf($mask, $driver['id'], $driver['name'], $driver['country']);
      }
   }

   private function chooseMainCar(): array|string
   {


      $car = new Car();
      if (!$car->checkIfMinCarExists()) {
         readLine('NAO EXISTE CARRO, APERTE E SERA DIRECIONADO PARA O CADASTRO. ');
         return (new CarMenu())->carMenu();
      }

      $this->printTableCars();
      $id = $prompt['car_id'] = readLine('Selecione seu Car pelo ID: ');


      if ($car->checkIfIdExist($id)) {
         return $prompt;
      }
      sleep(1);
      return $this->chooseMainCar();
   }

   private function printTableCars(): void
   {
      system('clear');
      display('CARROS CADASTRADOS');
      $car = new Car();
      $array = $car->findAll();

      $mask = "|%-3.3s|%-12.12s|%-12.12s|%-12.12s|%-12.12s|" . PHP_EOL;
      printf($mask, 'ID', 'MARCA', 'MODELO', 'COR', 'ANO');

      foreach ($array as $car) {
         printf($mask, $car['id'], $car['brand'], $car['model'], $car['color'], $car['yrs']);
      }

   }

   private function setAmountCompetitors(): array
   {
      system('clear');
      $driver = new Driver();
      $numMaxOfParticipantsPermittion = $driver->numberAllDrivers();
      $numMinOfParticipantsPermittion = 2;

      message("Numero máximo de corredores permitidos é: {$numMaxOfParticipantsPermittion}");
      $prompt['amount_competitors'] = readLine("digite o numero de participantes: ");

      if ($prompt['amount_competitors'] > $numMaxOfParticipantsPermittion || $prompt['amount_competitors'] < $numMinOfParticipantsPermittion) {
         message('Numero de participantes invalido');
         return $this->setAmountCompetitors();
      }
      return $prompt;
   }

   private function getRandomCar(array $cars): array
   {
      return $cars[array_rand($cars, 1)];
   }

   private function setWaitingCompetition($prompt): array
   {
      $competition = new Competition();

      $prompt['status'] = $competition::STATUS_WAITING;

      $competitionId = $competition->insert($prompt);
      $prompt['competition_id'] = $competitionId;
      return $prompt;
   }

   private function setCompetitors(array $prompt): array
   {
      $driver = new Driver();
      $adversaries = intval($prompt['amount_competitors']) - 1;

      $drivers = $driver->findAllAdversaries($prompt['driver_id'], $adversaries);

      $car = new Car();
      $cars = $car->findAllId();

      $competitors = [];
      $competitors[] = [
         'driver_id' => $prompt['driver_id'],
         'car_id' => $prompt['car_id'],
      ];

      foreach ($drivers as $driver) {
         $competitors[] = [
            'driver_id' => $driver['id'],
            'car_id' => $this->getRandomCar($cars)['id'],
         ];
      }

      $competitors = $this->getRandomPositions($competitors);

      $race = new Race();
      $race->insertRace($prompt['competition_id'], $competitors);
      return $competitors;
   }

   private function getRandomPositions(array $competitors): array
   {
      shuffle($competitors);
      return $competitors;
   }

}



