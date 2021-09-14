<?php

namespace App\view;

use App\models\Circuit;

class CircuitMenu
{
   public function circuitMenu(): string
   {
      $this->printCarMenu();

      $choice = match (readLine()) {
         '1' => $this->new(),
         '2' => $this->list(),
         '3' => $this->edit(),
         '4' => $this->delete(),
         '5' => (new MainMenu())->run(),

         default => reload($this->circuitMenu())
      };
      return $choice;
   }

   private function printCarMenu(): void
   {
      system('clear');
      display('__SELECIONE UMA OPÇÃO__');
      display('1- NOVO CIRCUITO');
      display('2- LISTAR CIRCUITOS');
      display('3- EDITAR CIRCUITOS');
      display('4- DELETAR CIRCUITO');
      display('5- VOLTAR PARA O MENU PRINCIPAL');
   }

   private function new(): string
   {
      display('__CADASTRO DE CIRCUITO__');

      $prompt = [];
      $prompt['circuit'] = readLine('Digite o nome do Circuito: ');
      $prompt['country'] = readLine('Digite o Pais do Circuito: ');
      $prompt['lengthKM'] = intval(readLine('Digite quanto quilometros tem o Circuito: '));
      $prompt['totalLaps'] = intval(readLine('Digite o numero de voltas: '));

      $circuit = new Circuit();
      $condition = $circuit->validate($prompt);
      if ($condition) {
         $circuit->new($prompt);
      }

      return $this->reloadCircuitMenu();
   }

   private function list(): string
   {
      display('__CIRCUITOS CADASTRADOS__');

      $circuit = new Circuit();
      $array = $circuit->findAll();

      $mask = "|%-3.3s|%-40.40s|%-16.16s|%-6.6s|%-6.6s|" . PHP_EOL;
      printf($mask, 'ID', 'NOME', 'PAIS', 'KM', 'VOLTAS');

      foreach ($array as $circuit) {
         printf($mask, $circuit['id'], $circuit['circuit'], $circuit['country'], $circuit['lengthKM'], $circuit['totalLaps']);
      }
      readline('PRESSIONE QUALQUER TECLA, PARA VOLTAR PRO MENU.');
      return $this->circuitMenu();
   }

   private function edit(): string
   {
      display('__EDITAR CARRO__');
      $circuit = new Circuit();
      $prompt = [];

      $prompt['id'] = trim(readLine('Digite ID: '));

      if ($circuit->checkIfIdExist($prompt['id'])) {

         message($circuit->info($circuit->findById($prompt['id'])));

         $option = trim(readLine('Digite Y para CONFIRMAR se o carro selecionado e o correto: '));
         $option = strtoupper($option);

         if ($option == 'Y') {
            $prompt['circuit'] = readLine('Digite o nome do Circuito: ');
            $prompt['country'] = readLine('Digite o Pais do Circuito: ');
            $prompt['lengthKM'] = readLine('Digite quanto quilometros tem o Circuito: ');
            $prompt['totalLaps'] = intval(readLine('Digite o numero de voltas: '));

            $condition = $circuit->validate($prompt);

            if ($condition) {
               echo $circuit->update($prompt);
            }
         }
      }
      return $this->reloadCircuitMenu();
   }

   public function info(array $data): string
   {
      return 'Gostaria de editar o ID: ' . $data['id'] .
         ', Marca: ' . $data['circuit'] . ' e Modelo: ' . $data['circuit'] . PHP_EOL;
   }
   private function delete()
   {
      echo "funcao será implementada em breve";
      return sleep(3) . $this->circuitMenu();
   }

   private function reloadCircuitMenu(): string
   {
      return sleep(5) . $this->circuitMenu();
   }
}