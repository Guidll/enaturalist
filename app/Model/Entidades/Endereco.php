<?php

namespace App\Model\Entidades;

use \App\Controller\Utilidades\Banco;
use \App\Model\Entidades\Usuario as EntidadeUsuario;

class Endereco {
  private $id;

  private $id_usuario;

  private $cep;

  private $rua;

  private $numero;

  private $bairro;

  private $cidade;

  private $estado;

  private $data;

  // ----- ----------------------------
  // ----- Inicio metodos padroes -----
  // ----- ----------------------------
  public function __construct() {
    $this->setData(date('Y-m-d H:i:s'));
  }


  public function getId() {
    return $this->id;
  }
  public function setId($id) {
    $this->id = $id;
  }


  public function getIdUsuario() {
    return $this->id_usuario;
  }
  public function setIdUsuario($id_usuario) {
    $this->id_usuario = $id_usuario;
  }


  public function getCep() {
    return $this->cep;
  }
  public function setCep($cepValor) {
    $this->cep = $cepValor;
  }


  public function getRua() {
    return $this->rua;
  }
  public function setRua($ruaValor) {
    $this->rua = $ruaValor;
  }


  public function getNumero() {
    return $this->numero;
  }
  public function setNumero($numeroValor) {
    $this->numero = $numeroValor;
  }


  public function getBairro() {
    return $this->bairro;
  }
  public function setBairro($bairroValor) {
    $this->bairro = $bairroValor;
  }


  public function getCidade() {
    return $this->cidade;
  }
  public function setCidade($cidadeValor) {
    $this->cidade = $cidadeValor;
  }


  public function getEstado() {
    return $this->estado;
  }
  public function setEstado($estadoValor) {
    $this->estado = $estadoValor;
  }


  public function getData() {
    return $this->data;
  }
  public function setData($dataValor) {
    $this->data = $dataValor;
  }
  // ----- -------------------------
  // ----- Fim Metodos padroes -----
  // ----- -------------------------

  public function cadastrar() {
    $this->setId((new Banco('endereco'))->insert([
      'id_usuario' => $this->getIdUsuario(),
      'cep' => $this->getCep(),
      'rua' => $this->getRua(),
      'numero' => $this->getNumero(),
      'bairro' => $this->getBairro(),
      'cidade' => $this->getCidade(),
      'estado' => $this->getEstado(),
      'data' => $this->getData(),
    ]));

    return true;
  }


  // public function atualizar() {
  //   return (new Banco('ecopontos'))->update('id = '. $this->id, [
  //     'endereco' => $this->endereco,
  //     'tag' => $this->tag,
  //   ]);
  // }


  // public function excluir() {
  //   return (new Banco('ecopontos'))->delete('id = ' . $this->id);
  // }


  public static function consultarEndereco($where = null, $order = null, $limit = null, $field = '*') {
    return (new Banco('endereco'))->select($where,$order,$limit,$field);
  }


  public static function consultarEnderecoPorIdUsuario($id_usuario) {
    return self::consultarEndereco('id_usuario = ' . $id_usuario)->fetchObject(self::class);
  }


  public static function consultarEnderecoPorId($id) {
    return self::consultarEndereco('id = ' . $id)->fetchObject(self::class);
  }
}