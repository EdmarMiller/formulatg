<?php

class Car extends Connection
{
    public $brand;
    public $model;
    public $color;
    public $yrs;

    public function __construct($brand, $model, $color, $yrs)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->color = $color;
        $this->yrs = $yrs;
    } /* Shift + Ctrl + /*/

    function createCar ($brand, $model,$color, $yrs) {
        $db = new Connection();
        $db = $db->conn();
        $sql = 'INSERT INTO cars( $brand , $model, $color, $yrs) VALUES (?,?,?,?)';
        $addCar = $db->prepare($sql);
        $addCar->bindValue(1, $brand);
        $addCar->bindValue(2, $model);
        $addCar->bindValue(3, $color);
        $addCar->bindValue(4, $yrs);
        $addCar->execute();
        $db = null;



    }
    function addCar() {}

    function updateCar(){}


}

$car = new Car("12","12","'11", "'12");
$car->createCar();










