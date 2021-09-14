<?php


namespace App\view;


use App\models\CreateTables;
use App\validate\TablesExist;


class MainMenu
{

   public function run(): string
   {

      $this->startTablesApp();
      $this->printMainMenu();

      $choice = match (readLine()) {
         '1' => (new DriverMenu())->driverMenu(),
         '2' => (new CarMenu())->carMenu(),
         '3' => (new CircuitMenu())->circuitMenu(),
         '4' => (new RunMenu())->runMenu(),
         '5' => $this->endGame(),
         default => reload($this->run())
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
      display('3- CIRCUITOS');
      display('4- CORRER');
      display('5- SAIR');

   }

   private function startTablesApp()
   {
      $t = new TablesExist();
      if (!$t->initialTables()) {
         $c = new CreateTables();
         $c->createAll();
      }
   }

   private function endGame(): string
   {
      system('clear');
      message('__OBRIGADO POR JOGAR__');
      sleep(1.5) . system('clear');
      return exit();
   }
}