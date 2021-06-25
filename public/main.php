<?php

require __DIR__ . DIRECTORY_SEPARATOR;
require __DIR__ . DIRECTORY_SEPARATOR;;

$today = date('j-m-y');
echo "$today";

//$d = new Driver();
//$array = $p->find();
//
//print_r($array);
//
//$array = (shuffle($array));
//
//print_r($array);
//
//
//// Sorteio do inicio da corrida
//echo "\n\n\n";

//$numbers = range(1, 10);
//echo "\n\n";
//print_r($numbers);
//echo "\n\n";
//
//$num1 = $numbers[4];
//$num2 = $numbers[3];
//
//
//if ($num1 > $num2) {
//   echo "{$num1} é maior {$num2})";
//} else {
//    echo "{$num1} é menor {$num2} ";
//}


$p = new Driver();
$data = $p->find();
//print_r($data);

foreach ($data as ["id" => $id, "name" => $name, "status" => $status]) {
   echo "id: $id | name: $name | position: $status |\n";
}

function passar(int $idAttack, int $idDefend): void
{
   $sql = "UPDATE drivers SET name=?, country=? WHERE id=$id";

   $update = $this->pdo->prepare($sql);
   $update->execute([$name, $country]);
}
passar();

//foreach ($numbers as $number) {
//   echo "$number ";
//}

/*TODO Setar position de largada, shuffle ou não
$numbers = range(1, 25);
foreach ($numbers as $number) {
   echo "$number ";*/
//}
//echo"\n";
//
//shuffle($numbers);
//
//foreach ($numbers as $number) {
//   echo "$number ";
//}
//echo"\n";
// TODO Contar itens Array


// Usar para retornar Msg de numero de participantes solicitados, maiores que os Registrados.
//$count = count($array)
//print_r(count($count));





