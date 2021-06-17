<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'src/models/Connection.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'src/controller/Player.php';


function obterOpcaoUsuario()
{
   echo gmdate('Y-m-d H:i:s');
   echo("\n!!!---> WELCOME FORMULA TG <---!!!\n");
   //echo microtime();

   echo("WELCOME CHOISE AN OPTION\n");

   echo("1- RUN\n");
   echo("2- CARS\n");
   echo("3- PLAYERS\n");

   echo("\nX- EXIT\n");

   $opcaoUsuario = readLine();
   $opcaoUsuario = strtoupper($opcaoUsuario);

   echo("\n");

   return ($opcaoUsuario);

}
function op ()
{
   while ($opcaoUsuario !== "X") {
      switch ($opcaoUsuario) {
         case 1:
            echo "Cadastrar Player \n";
            echo "pegar os dados aqui";
            echo "pegar os dados aqui";
            echo "pegar os dados aqui";
            echo "pegar os dados aqui";
            break;
         case 2:
            echo"Aqui vamos cadastrar algoooo\n";

            break;
         case 3:
            echo "Visualizar Grid \n";
            obterOpcaoPlayer();
            break;
         case 4:
            echo "Iniciar Corrida \n";
            break;
         default:
            echo "Selecione uma opção valida ou X para sair\n";

      }

      $opcaoUsuario = obterOpcaoUsuario();
   }
}

op();



function cadastrarPlayer() {
    echo("\n!!!----> FG RANCING <----!!!\n");
    echo("\n!!!----> CADASTRAR player <----!!!\n\n");

    $brand = readline("Digite a Marca: ");
    $model =readline("Digite a Modelo: ");
    $color = readline("Digite a cor: ");
    $yrs =readline("Digite o Ano: ");

}


function obterOpcaoPlayer()
{
   echo gmdate('Y-m-d H:i:s');
   echo("\n!!!---> WELCOME FORMULA TG <---!!!\n");
   //echo microtime();

   echo("WELCOME CHOISE AN OPTION\n");

   echo("1- CREATE\n");
   echo("2- VIEW\n");
   echo("3- UPDATE\n");
   echo("4- DELETE\n");

   echo("5- BACK\n");

   echo("\nX- EXIT\n");

   $opcaoUsuario = readLine();
   $opcaoUsuario = strtoupper($opcaoUsuario);

   echo("\n");

   return ($opcaoUsuario);

}







