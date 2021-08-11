<?php

namespace App\view;

use App\models\Competition;
use App\models\Connection;
use App\models\Race;


class RaceMenu
{

   private $pdo;

   public function __construct()
   {
      $this->pdo = (new Connection())->conn();
   }

//TODO: Mudar esse class pra GridMenu... vai fazer mais sentido

   public function raceMenu($prompt)
   {
      $this->printRaceMenu();

      $choice = match (readLine()) {
         '1' => $this->start($prompt),
         '2' => $this->listGrid($prompt),
         '3' => $this->setCanceledStatus($prompt),

         default => $this->defaultRaceMenu($prompt)
      };
      return $choice;
   }

   private function printRaceMenu(): void
   {
      system('clear');
      display('__SELECIONE UMA OPÇÃO__');
      display('1- INICIAR');
      display('2- LISTAR GRID');
      display('3- CANCELAR');
   }

   private function defaultRaceMenu($prompt)
   {
      display('ESCOLHA UMA OPÇÃO VÁLIDA');
      return $this->reloadRaceMenu($prompt);
   }

   private function start($prompt): array
   {

      $this->list($prompt);
      $this->setInProgressStatus($prompt);
      $this->raceInProgressMenu($prompt);

      return $prompt;
   }

   public function raceInProgressMenu($prompt)
   {

      $this->printRaceInProgressMenu($prompt);

      $choice = match (readLine()) {
         '1' => $this->chooseAdv($prompt),
         '3' => $this->setFinishedStatus($prompt),
         default => $this->defaultRaceMenu($prompt)
      };
      return $choice;
   }

   private function printRaceInProgressMenu($prompt): void
   {

      system('clear');
      display('__CORRIDA EM ANDAMENTO');
      display('__SELECIONE UMA OPÇÃO__') . PHP_EOL;
      $this->list($prompt);

      display('1- ULTRAPASSAR');
      display('3- FINALIZAR');

   }

   private function listGrid($prompt)
   {
      display('__LARGADA__');
      $this->list($prompt);
      readline('Aperte ENTER para voltar para menu');
      return $this->raceMenu($prompt);
   }

   private function list($prompt)
   {

      $race = new Race();
      $race = $race->find($prompt['competition_id']);

      $mask = "|%-3.3s|%-11.11s|%-11.11s|%-7.7s|" . PHP_EOL;
      printf($mask, 'ID', 'PILOTO', 'MODELO', 'POSICAO');

      foreach ($race as $competitor) {
         printf($mask, $competitor['id'], $competitor['name'], $competitor['model'], $competitor['position']);
      }
      return $competitor;
   }

   private function infoMainDriver($prompt)
   {

      $race = new Race();
      $race = $race->findMainDriver($prompt['competition_id'],$prompt['drive_id']);

      $mask = "|%-3.3s|%-11.11s|%-11.11s|%-7.7s|" . PHP_EOL;
      printf($mask, 'ID', 'PILOTO', 'MODELO', 'POSICAO');

      foreach ($race as $competitor) {
         printf($mask, $competitor['id'], $competitor['name'], $competitor['model'], $competitor['position']);
      }
      return $competitor;
   }

   private function setInProgressStatus($prompt)
   {
      $competition = new Competition();
      $prompt['status'] = $competition::STATUS_IN_PROGRESS;
      $competition->update($prompt);

      return $prompt['status'];
   }

   private function setCanceledStatus($prompt)
   {
      $competition = new Competition();
      $prompt['status'] = $competition::STATUS_CANCELED;
      $competition->update($prompt);

      message('CORRIDA CANCELADA COM SUCESSO!');
      return sleep(1.5) . (new MainMenu())->run();
   }

   private function setFinishedStatus($prompt)
   {
      $competition = new Competition();
      $prompt['status'] = $competition::STATUS_FINISHED;
      $competition->update($prompt);

      message('CORRIDA FINALIZADA COM SUCESSO!');
      $this->list($prompt);

      readline('Enter para ir para finalizar e ir para o menu principal');

      return sleep(1.5) . (new MainMenu())->run();
   }

   private function overtake($competition_id, $idDriver, $idAdv)
   {
      $positionDriver = $this->getPosition($competition_id, $idDriver);
      $positionAdv = $this->getPosition($competition_id, $idAdv);

      if ($this->validateOvertake($positionDriver, $positionAdv)) {

         $this->updatePosition($positionAdv, $competition_id, $idDriver);
         $this->updatePosition($positionDriver, $competition_id, $idAdv);

         $this->registerOvertake($competition_id, $idDriver, $idAdv, $positionDriver, $positionAdv);
         readline('Deu bom! Parabens, conseguiu ultrapassar!');

      }

   }

   private function chooseAdv($prompt): array
   {
      system('clear');
      $this->list($prompt);

      $idAdv = trim(readline('Digite o id de quem gostaria de ultrapassar'));
//
      if ($idAdv != "") {
         if (preg_match("/^([0-9]+)$/", $idAdv)) {
            if ($this->checkIfIdExists($prompt, $idAdv)) {
               $this->overtake($prompt['competition_id'], $prompt['drive_id'], $idAdv);
               return $this->raceInProgressMenu($prompt);
            }
         } else {
            readline('O id precisa ser um numero. Favor digitar um id valido');
            return $this->raceInProgressMenu($prompt);
         }
      }
      readline('Campo Vazio! Digite um id valido.');
      return $this->raceInProgressMenu($prompt);
   }

   public function checkIfIdExists($prompt, $id): bool
   {
      $sql = "SELECT COUNT(*) FROM `race` WHERE competition_id = " . $prompt['competition_id'] . " AND driver_id = " . $id;
      $res = $this->pdo->query($sql);
      $count = $res->fetchColumn();

      if ($count > 0) {
         return true;
      }
      message('ID não encontrado') . sleep(1.2);
      return false;
   }

   private function validateOvertake($positionDriver, $positionAdv): bool
   {
      if ($positionAdv > $positionDriver || ($positionDriver - $positionAdv) != 1) {
         message('Ultrapassagem não permitida') . sleep(1.2);
         return false;
      }
      return true;
   }

   public function getPosition($competition_id, $idDriver)
   {
      $position = $this->pdo
         ->query("SELECT `position` FROM `race` WHERE race.competition_id = $competition_id AND race.driver_id = $idDriver")
         ->fetchColumn();

      return (int)$position;
   }

   public function updatePosition($position, $competition_id, $idDriver): void
   {
      $sql = "UPDATE `race` SET `position`=? WHERE `competition_id`=? AND `driver_id`= ?";

      $update = $this->pdo->prepare($sql);
      $update->execute([$position, $competition_id, $idDriver]);

   }

   public function registerOvertake($competition_id, $idDriver, $idAdv, $positionDriver, $positionAdv): void
   {
      $sql = 'INSERT INTO `race_history`(`race_id` , `driver_win_position` , `driver_loss_position` , `position_of`, `position_to`) VALUES (?,?,?,?,?)';
      $this->pdo
         ->prepare($sql)
         ->execute([$competition_id, $idDriver, $idAdv, $positionDriver, $positionAdv]);
   }

   private function reloadRaceMenu($prompt)
   {
      return sleep(1.2) . $this->raceMenu($prompt);
   }
}