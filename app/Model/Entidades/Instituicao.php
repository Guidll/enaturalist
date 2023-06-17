<?php

namespace App\Model\Entidades;

use \App\Controller\Utilidades\Banco;
use \App\Model\Entidades\Usuario as EntidadeUsuario;

class Instituicao
{
  private $id;

  private $nome;

  private $email;

  private $senha;

  private $cnpj;

  private $celular;

  private $endereco;

  // ----- ----------------------------
  // ----- Inicio metodos padroes -----
  // ----- ----------------------------
  public function __construct() {

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


  public function getCnpj() {
    return $this->cnpj;
  }
  public function setCnpj($cnpj) {
    $this->cnpj = $cnpj;
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

  public static function instituicaoPorEmailSelecionar($email) {
    return (new Banco('instituicoes'))->select('email = "' . $email . '"')->fetchObject(self::class);
  }


  public static function getInstituicao($where = null, $order = null, $limit = null, $field = '*') {
    return (new Banco('instituicoes'))->select($where,$order,$limit,$field);
  }


  public function cadastrar() {
    $this->id = (new Banco('instituicoes'))->insert([
      'nome' => $this->getNome(),
      'email' => $this->getEmail(),
      'senha' => $this->getSenha(),
      'cnpj' => $this->getCnpj(),
      'celular' => $this->getCelular(),
      'endereco' => $this->getEndereco(),
    ]);

    return true;
  }


  public static function getInstituicaoId() {
    return self::getInstituicao()->fetchObject(self::class)->id;
  }


  public static function getInstituicaoPorId($id) {
    return self::getInstituicao('id = ' . $id)->fetchObject(self::class);
  }


  public static function getInstituicaoEndereco() {
    return self::getInstituicao()->fetchObject(self::class)->endereco;
  }


  public static function getInstituicaoCelular() {
    return self::getInstituicao()->fetchObject(self::class)->celular;
  }


  public function setUsuarioEndereco($id) {
    return (new Banco('instituicoes'))->update('id = '. $this->getId(), [
      'endereco' => $id,
    ]);
  }
}