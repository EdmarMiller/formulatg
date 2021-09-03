<?php

namespace App\view;

use App\models\Car;

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

         default => reload($this->carMenu())
      };
      return $choice;
   }

   private function printCarMenu(): void
   {
      system('clear');
      display('__SELECIONE UMA OPÇÃO__');
      display('1- NOVO CARRO');
      display('2- LISTAR CARROS');
      display('3- EDITAR CARROS');
      display('4- DELETAR CARRO');
      display('5- VOLTAR PARA O MENU PRINCIPAL');
   }

   private function new(): string
   {
      display('__CADASTRAR DE CARRO__');

      $prompt = [];
      $prompt['brand'] = readLine('digite a marca: ');
      $prompt['model'] = readLine('digite o modelo: ');
      $prompt['color'] = readLine('digite a cor: ');
      $prompt['yrs'] = intval(readLine('digite o ano: '));

      $car = new Car();
      $condition = $car->validate($prompt);
      if ($condition) {
         $car->newCar($prompt);
      }

      return $this->reloadCarMenu();
   }

   private function list(): string
   {
      display('__CARROS CADASTRADOS__');

      $car = new Car();
      $cars = $car->findAll();

      $mask = "|%-3.3s|%-11.11s|%-11.11s|%-11.11s|%-5.5s|" . PHP_EOL;
      printf($mask, 'ID', 'MARCA', 'MODELO', 'COR', 'ANO');

      foreach ($cars as $car) {
         printf($mask, $car['id'], $car['brand'], $car['model'], $car['color'], $car['yrs']);
      }
      readline('PRESSIONE QUALQUER TECLA, PARA VOLTAR PRO MENU.');
      return $this->carMenu();
   }

   private function edit(): string
   {
      display('__EDITAR CARRO__');
      $car = new Car();
      $prompt = [];

      $prompt['id'] = trim(readLine('Digite ID: '));

      if ($car->checkIfIdExist($prompt['id'])) {

         message($car->info($car->findById($prompt['id'])));

         $option = trim(readLine('Digite Y para CONFIRMAR se o carro selecionado e o correto: '));
         $option = strtoupper($option);

         if ($option == 'Y') {
            $prompt['brand'] = trim(readLine('digite o nova marca: '));
            $prompt['model'] = trim(readLine('digite o novo modelo: '));
            $prompt['color'] = trim(readLine('digite o nova cor: '));
            $prompt['yrs'] = trim(readLine('digite o novo ano: '));

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
         display('__DELETAR CARRO__');
         $car = new Car();
         $prompt = [];

         $id = $prompt['id'] = trim(readLine('Digite ID: '));

         if ($car->checkIfIdExist($id)) {
            message($car->msgDelete($car->findById($id)));

            $prompt['model'] = trim(readLine('Digite o MODELO e aperte ENTER para DELETAR: '));

            if ($prompt['model'] == $car->findById($id)['model']) {
               $car->delete($id);
               message('O carro DELETADO com sucesso!');
            } else {
               message('Favor conferir os dados, carro nao DELETADO!');
            }
         }
         return $this->reloadCarMenu();
      }
   }

   private function reloadCarMenu(): string
   {
      return sleep(3) . $this->carMenu();
   }
}