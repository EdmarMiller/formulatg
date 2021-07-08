<?php

namespace App;


class DriverMenu
{
   public function driverMenu(): string
   {
      $this->printDriverMenu();

      $choice = match (readLine()) {
         '1' => $this->new(),
         '2' => $this->list(),
         '3' => $this->edit(),
         '4' => $this->delete(),
         '5' => (new MainMenu())->run(),

         default => $this->defaultDriverMenu()
      };
      return $choice;
   }

   private function printDriverMenu(): void
   {
      system('clear');
      display('__DRIVER OPTION__');
      display('1- NEW DRIVER');
      display('2- LIST DRIVERS');
      display('3- EDIT DRIVERS');
      display('4- DELETE DRIVERS');
      display('5- BACK TO HOME');
   }

   private function defaultDriverMenu(): string
   {
      message('ESCOLHA UMA OPÇÃO VÁLIDA');
      return $this->reloadDriverMenu();
   }

   private function new(): string
   {
      display('__CADASTRAR NEW DRIVER__');
      $prompt = [];
      $prompt['name'] = trim(readLine("digite seu nome: "));
      $prompt['country'] = trim(readLine("digite seu pais: "));

      $driver = new Driver();
      $condition = $driver->validate($prompt);

      if ($condition) {
         echo $driver->newDriver($prompt);
      }

      return $this->reloadDriverMenu();
   }

   private function list(): string
   {
      display('PILOTOS CADASTRADOS');
      $driver = new Driver();
      $array = $driver->findAll();

      $mask = "|%-3.3s|%-12.12s|%-12.12s|" . PHP_EOL;
      printf($mask, 'ID', 'NOME', 'PAIS');

      foreach ($array as $driver) {
         printf($mask, $driver['id'], $driver['name'], $driver['country']);
      }
      readline('Aperte qualquer tecla para continuar');
      return $this->driverMenu();
   }

   private function edit(): string
   {
      display('__EDITAR DRIVER__');
      $driver = new Driver();
      $prompt = [];

      $prompt['id'] = trim(readLine("Digite ID: "));

      if ($driver->checkIdExist($prompt['id'])) {
         message($driver->info($driver->findById($prompt['id'])));

         $option = trim(readLine("Digite Y para confirmar selecao: "));
         $option = strtoupper($option);

         if ($option == 'Y') {
            $prompt['name'] = trim(readLine("digite o novo nome: "));
            $prompt['country'] = trim(readLine("digite o novo pais: "));

            $condition = $driver->validate($prompt);

            if ($condition) {
               echo $driver->update($prompt);
            }
         }
      }
      return $this->reloadDriverMenu();
   }

   private function delete()
   {
      {
         display('__EDITAR DRIVER__');
         $driver = new Driver();
         $prompt = [];

         $id = $prompt['id'] = trim(readLine("Digite ID: "));

         if ($driver->checkIdExist($id)) {
            message($driver->info($driver->findById($id)));

            $prompt['name'] = trim(readLine("Digite o nome e aperte enter para deletar: "));

            if ($prompt['name'] == $driver->findById($id)['name']) {
               $driver->delete($id);
               message('Driver deletado');
            } else {
               message('Operação NÃO efetuada!!!');
            }
         }
         return $this->reloadDriverMenu();
      }
   }

   private function reloadDriverMenu(): string
   {
      return sleep(1.5) . $this->driverMenu();
   }


}