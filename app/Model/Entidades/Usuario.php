<?php

namespace App\Model\Entidades;

use \App\Controller\Utilidades\Banco;

class Usuario
{
  public $id;

  public $nome;

  public $email;

  public $cpf;

  public $cnpj;

  public $senha;

  public $celular;

  public $endereco;


  public static function usuarioPorEmailSelecionar($email)
  {
    return (new Banco('usuarios'))->select('email = "' . $email . '"')->fetchObject(self::class);
  }


  public static function getUsuario($where = null, $order = null, $limit = null, $field = '*')
  {
    return (new Banco('usuarios'))->select($where,$order,$limit,$field);
  }


  public function setUsuario()
  {
    $this->id = (new Banco('usuarios'))->insert([
      'nome' => $this->nome,
      'email' => $this->email,
      'senha' => $this->senha,
      'cpf' => $this->cpf ?? '',
      'cnpj' => $this->cnpj ?? '',
      'endereco' => $this->endereco,
      'celular' => $this->celular,
    ]);

    return true;
  }


  public static function getUsuarioId() {
    return self::getUsuario('id = ' . $_SESSION['admin']['usuario']['id'])->fetchObject(self::class)->id;
  }
  
  
  public static function getUsuarioPorId($id) {
    return self::getUsuario('id = ' . $id)->fetchObject(self::class);
  }


  public static function getUsuarioEndereco() {
    return self::getUsuario()->fetchObject(self::class)->endereco;
  }


  public static function getUsuarioCelular() {
    return self::getUsuario()->fetchObject(self::class)->celular;
  }


  public static function getUsuarioCnpj($id) {
    return self::getUsuario('id = ' . $id)->fetchObject(self::class)->cnpj;
  }
}