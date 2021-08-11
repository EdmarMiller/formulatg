<?php


namespace App\view;


use App\models\Driver;

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
      display('__SELECIONE UMA OPÇÃO__');
      display('1- NOVO PILOTO');
      display('2- LISTAR PILOTOS');
      display('3- EDITAR PILOTOS');
      display('4- DELETAR PILOTOSS');
      display('5- VOLTAR PARA O MENU PRINCIPAL');
   }

   private function defaultDriverMenu(): string
   {
      message('ESCOLHA UMA OPÇÃO VÁLIDA');
      return $this->reloadDriverMenu();
   }

   private function new(): string
   {
      display('__CADASTRAR NOVO PILOTO__');
      $prompt = [];
      $prompt['name'] = trim(readLine('digite seu nome: '));
      $prompt['country'] = trim(readLine('digite seu pais: '));

      $driver = new Driver();
      $condition = $driver->validate($prompt);

      if ($condition) {
         echo $driver->newDriver($prompt);
      }

      return $this->reloadDriverMenu();
   }

   private function list(): string
   {
      display('__PILOTOS CADASTRADOS__');
      $driver = new Driver();
      $array = $driver->findAll();

      $mask = "|%-3.3s|%-12.12s|%-12.12s|" . PHP_EOL;
      printf($mask, 'ID', 'NOME', 'PAIS');

      foreach ($array as $driver) {
         printf($mask, $driver['id'], $driver['name'], $driver['country']);
      }
      readline('PRESSIONE QUALQUER TECLA, PARA VOLTAR PRO MENU.');
      return $this->driverMenu();
   }

   private function edit(): string
   {
      display('__EDITAR DRIVER__');
      $driver = new Driver();
      $prompt = [];

      $prompt['id'] = trim(readLine('Digite ID: '));

      if ($driver->checkIfIdExists($prompt['id'])) {
         message($driver->info($driver->findById($prompt['id'])));

         $option = trim(readLine('Digite Y para CONFIRMAR se o PILOTO selecionado e o correto: '));
         $option = strtoupper($option);

         if ($option == 'Y') {
            $prompt['name'] = trim(readLine('digite o novo nome: '));
            $prompt['country'] = trim(readLine('digite o novo pais: '));

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
         display('__EDITAR PILOTO__');
         $driver = new Driver();
         $prompt = [];

         $id = $prompt['id'] = trim(readLine('Digite ID: '));

         if ($driver->checkIfIdExists($id)) {
            message($driver->info($driver->findById($id)));

            $prompt['name'] = trim(readLine('Digite o nome e aperte enter para DELETAR: '));

            if ($prompt['name'] == $driver->findById($id)['name']) {
               $driver->delete($id);
               message('Piloto deletado');
            } else {
               message('O Piloto não foi deletado, confira os dados!!!');
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