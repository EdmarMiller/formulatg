<?php


namespace App\view;


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
      display('___ BEM VINDO(A) A FORMULA TG ___');
      display('ESCOLHA UMA OPÇÃO');
      display('1- PILOTOS');
      display('2- CARROS');
      display('3- CORRER');
      display('5- SAIR');

   }

   private function defaultMainMenu(): string
   {
      message('ESCOLHA UMA OPÇÃO VÁLIDA');
      return sleep(1.5) . $this->run();
   }

   private function endGame(): string
   {
      system('clear');
      message('__OBRIGADO POR JOGAR__');
      sleep(1.5) . system('clear');
      return exit();
   }
}