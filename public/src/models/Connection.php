<?php

class Connection
{
   private $_dbHostname = "database";
   private $_dbName = "formula_tg";
   private $_dbUsername = "api";
   private $_dbPassword = "api123";
   private $_con;

   public function __construct()
   {
      try {
         $this->_con = new PDO("mysql:host=$this->_dbHostname;dbname=$this->_dbName", $this->_dbUsername, $this->_dbPassword);
         $this->_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      } catch (PDOException $e) {
         echo "<h3>Ops, algo deu errado: " . $e->getMessage() . "</h3>";
         echo "<pre>";
         echo print_r($e);
      }

   }

   public function conn(): PDO
   {
      return $this->_con;
   }
}

