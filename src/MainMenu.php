<?php


namespace App;


class MainMenu
{
   public function run(): string
   {
      $this->printMainMenu();

      $choice = match (readLine()) {
         '1' => (new DriverMenu())->driverMenu(),
         '2' => (new CarMenu())->carMenu(),
         '3' => (new RunMenu())->runMenu(),
         '5' => $this->endGame(),
         default => $this->defaultMainMenu()
      };
      return $choice;
   }

   private function printMainMenu(): void
   {
      system('clear');
      display('___ WELCOME FORMULA TG ___');
      display('CHOISE AN OPTION');
      display('1- DRIVERS');
      display('2- CARS');
      display('3- RUN');
      display('5- EXIT');

   }

   private function defaultMainMenu(): string
   {
      message('ESCOLHA UMA OPÇÃO VÁLIDA');
      return sleep(1.5) . $this->run();
   }

   private function endGame(): string
   {
      system('clear');
      message('__Obrigado por jogar__');
      sleep(1.5) . system('clear');
      return exit();
   }
}