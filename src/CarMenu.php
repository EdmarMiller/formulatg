<?php

namespace App;

class CarMenu
{
   public function carMenu(): string
   {
      $this->printCarMenu();

      $choice = match (readLine()) {
         '1' => $this->new(),
         '2' => $this->list(),
         '3' => $this->edit(),
         '4' => $this->delete(),
         '5' => (new MainMenu())->run(),

         default => $this->defaultCarMenu()
      };
      return $choice;
   }

   private function printCarMenu(): void
   {
      display('__CAR OPTION__');
      display('1- NEW CAR');
      display('2- LIST CAR');
      display('3- EDIT CAR');
      display('4- DELETE CAR');
      display('5- BACK TO HOME');
   }

   private function defaultCarMenu(): string
   {
      display('ESCOLHA UMA OPÇÃO VÁLIDA');
      return $this->reloadCarMenu();
   }

   private function new(): string
   {
      display('CADASTRO NEW CAR');

      $prompt = [];
      $prompt['brand'] = readLine("digite a marca: ");
      $prompt['model'] = readLine("digite o modelo: ");
      $prompt['color'] = readLine("digite a cor: ");
      $prompt['yrs'] = intval(readLine("digite o ano: "));

      $car = new Car();
      $condition = $car->validate($prompt);
      if ($condition) {
         $car->newCar($prompt);
      }

      return $this->reloadCarMenu();
   }

   private function list(): string
   {
      display('CARROS CADASTRADOS');
      $car = new Car();
      $array = $car->findAll();

      $mask = "|%-3.3s|%-12.12s|%-12.12s|%-12.12s|%-12.12s|" . PHP_EOL;
      printf($mask, 'ID', 'MARCA', 'MODELO', 'COR', 'ANO');

      foreach ($array as $car) {
         printf($mask, $car['id'], $car['brand'], $car['model'], $car['color'], $car['yrs']);
      }
      readline('Aperte qualquer tecla para continuar');
      return $this->carMenu();
   }

   private function edit(): string
   {
      display('__EDITAR DRIVER__');
      $car = new Car();
      $prompt = [];

      $prompt['id'] = trim(readLine("Digite ID: "));

      if ($car->checkIdExist($prompt['id'])) {

         message($car->info($car->findById($prompt['id'])));

         $option = trim(readLine("Digite Y para confirmar selecao: "));
         $option = strtoupper($option);

         if ($option == 'Y') {
            $prompt['brand'] = trim(readLine("digite o nova marca: "));
            $prompt['model'] = trim(readLine("digite o novo modelo: "));
            $prompt['color'] = trim(readLine("digite o nova cor: "));
            $prompt['yrs'] = trim(readLine("digite o novo ano: "));

            $condition = $car->validate($prompt);

            if ($condition) {
               echo $car->update($prompt);
            }
         }
      }
      return $this->reloadCarMenu();
   }

   private function delete()
   {
      {
         display('__EDITAR DRIVER__');
         $car = new Car();
         $prompt = [];

         $id = $prompt['id'] = trim(readLine("Digite ID: "));

         if ($car->checkIdExist($id)) {
            message($car->info($car->findById($id)));

            $prompt['model'] = trim(readLine("Digite o Modelo e aperte enter para deletar: "));

            if ($prompt['model'] == $car->findById($id)['model']) {
               $car->delete($id);
               message('Carro deletado');
            } else {
               message('Operação NÃO efetuada!!!');
            }
         }
         return $this->reloadCarMenu();
      }
   }

   private function reloadCarMenu(): string
   {
      return sleep(1.5) . $this->carMenu();
   }
}