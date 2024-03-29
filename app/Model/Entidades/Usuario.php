<?php

namespace App\Model\Entidades;

use \App\Controller\Utilidades\Banco;

class Usuario
{
  public $id;

  public $nome;

  public $email;

  public $cpf;

  public $senha;

  public $celular;

  public $endereco;

  // ----- ----------------------------
  // ----- Inicio metodos padroes -----
  // ----- ----------------------------
  public function __construct() {
    // $this->setData(date('Y-m-d H:i:s'));
  }


  public function getId() {
    return $this->id;
  }
  public function setId($id) {
    $this->id = $id;
  }


  public function getNome() {
    return $this->nome;
  }
  public function setNome($nome) {
    $this->nome = $nome;
  }


  public function getEmail() {
    return $this->email;
  }
  public function setEmail($email) {
    $this->email = $email;
  }


  public function getCpf() {
    return $this->cpf;
  }
  public function setCpf($cpf) {
    $this->cpf = $cpf;
  }


  public function getSenha() {
    return $this->senha;
  }
  public function setSenha($senha) {
    $this->senha = $senha;
  }


  public function getCelular() {
    return $this->celular;
  }
  public function setCelular($celular) {
    $this->celular = $celular;
  }


  public function getEndereco() {
    return $this->endereco;
  }
  public function setEndereco($endereco) {
    $this->endereco = $endereco;
  }
  // ----- -------------------------
  // ----- Fim Metodos padroes -----
  // ----- -------------------------


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
      'cpf' => $this->cpf,
      'endereco' => $this->endereco,
      'celular' => $this->celular,
    ]);

    return true;
  }


  public function setUsuarioEndereco($id) {
    return (new Banco('usuarios'))->update('id = '. $this->id, [
      'endereco' => $id,
    ]);
  }


  // Precisa remover esse metodo
  public static function getUsuarioId() {
    return self::getUsuario('id = ' . $_SESSION['admin']['usuario']['id'])->fetchObject(self::class)->id;
  }


  public static function getUsuarioPorId($id) {
    return self::getUsuario('id = ' . $id)->fetchObject(self::class);
  }


  public static function getUsuarioEndereco() {
    return self::getUsuario()->fetchObject(self::class)->endereco;
  }

  public static function getUsuarioEnderecoPorId($id) {
    return self::getUsuario('id = ' . $id)->fetchObject(self::class)->endereco;
  }


  public static function getUsuarioCelular() {
    return self::getUsuario()->fetchObject(self::class)->celular;
  }


  public static function getUsuarioCelularPorId($id) {
    return self::getUsuario('id = ' . $id)->fetchObject(self::class)->celular;
  }


  public static function getUsuarioCnpj($id) {
    return self::getUsuario('id = ' . $id)->fetchObject(self::class)->cnpj;
  }
}