<?php


class Circuit
{
   private $cod_usuario;
   private $nome;
   private $email;
   private $senha;
   private $ativo;
   private $perfil;

   public function setCod_usuario($cod_usuario)
   {
      $this->cod_usuario = $cod_usuario;
   }

   public function getNome()
   {
      return $this->nome;
   }

   public function setNome($nome)
   {
      $this->nome = $nome;
   }

   public function getEmail()
   {
      return $this->email;
   }

   public function setEmail($email)
   {
      $this->email = strtolower($email);
   }

   public function getSenha()
   {
      return $this->senha;
   }

   public function setSenha($senha)
   {
      $this->senha = strtolower($senha);
   }

   public function getAtivo()
   {
      return $this->ativo;
   }

   public function setAtivo($ativo)
   {
      $this->ativo = strtolower($ativo);
   }

   public function getPerfil()
   {
      return $this->perfil;
   }

   public function setPerfil($perfil)
   {
      $this->perfil = $perfil;
   }
}