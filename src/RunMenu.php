<?php


namespace App;


class RunMenu
{

   public function runMenu(): string
   {
      system('clear');
      $this->printRunMenu();

      $choice = match (readLine()) {
         '1' => (new SetupRace())->setupRace(),

         '5' => (new MainMenu())->run(),

         default => $this->defaultRunMenu()
      };
      return $choice;
   }

   private function printRunMenu(): void
   {
      system('clear');
      display('__RUN OPTION__');
      display('1- SETUP RACE');
      display('5- BACK TO HOME');
   }

   private function defaultRunMenu(): string
   {
      message('ESCOLHA UMA OPÇÃO VÁLIDA');
      return $this->reloadRunMenu();
   }

   private function reloadRunMenu(): string
   {
      return sleep(1.5) . $this->runMenu();
   }

}



