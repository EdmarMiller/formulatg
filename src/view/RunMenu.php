<?php


namespace App\view;


class RunMenu
{
   public function runMenu(): string
   {
      $this->printRunMenu();

      $choice = match (readLine()) {
         '1' => (new SetupRace())->setupRace(),
         '5' => (new MainMenu())->run(),

         default => reload($this->runMenu())
      };
      return $choice;
   }

   private function printRunMenu(): void
   {
      system('clear');
      display('__CONFIGURAÇÃO DA CORRIDA__');
      display('1- CONFIGURAR CORRIDA');
      display('5- VOLTAR PARA O MENU PRINCIPAL');
   }

}



