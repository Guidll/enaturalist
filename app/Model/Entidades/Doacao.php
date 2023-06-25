<?php

namespace App\Model\Entidades;

use \App\Controller\Utilidades\Banco;
use \App\Model\Entidades\Usuario;

class Doacao extends Usuario
{
  public $id;

  public $id_usuario;

  public $material;

  public $quantidade;

  public $descricao;

  public $requisitado;

  public $aceito;

  private $data;

  // ----------------------------------
  // ----- Inicio metodos padroes -----
  // ----------------------------------
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


  public function getMaterial() {
    return $this->material;
  }
  public function setMaterial($materialValor) {
    $this->material = $materialValor;
  }


  public function getQuantidade() {
    return $this->quantidade;
  }
  public function setQuantidade($quantidadeValor) {
    $this->quantidade = $quantidadeValor;
  }


  public function getRequisitado() {
    return $this->requisitado;
  }
  public function setRequisitado($requisitadoValor) {
    $this->requisitado = $requisitadoValor;
  }


  public function getAceito() {
    return $this->aceito;
  }
  public function setAceito($aceitoValor) {
    $this->aceito = $aceitoValor;
  }


  public function getData() {
    return $this->data;
  }
  public function setData($dataValor) {
    $this->data = $dataValor;
  }

  // -------------------------------
  // ----- Fim Metodos padroes -----
  // -------------------------------


  public function cadastrar()
  {
    $this->data = date('Y-m-d H:i:s');

    $this->id = (new Banco('doacao'))->insert([
      'id_usuario' => $_SESSION['admin']['usuario']['id'],
      'material' => $this->material,
      'quantidade' => $this->quantidade,
      'data' => $this->getData(),
    ]);

    return true;
  }


  public function atualizar()
  {
    return (new Banco('doacao'))->update('id = '. $this->id, [
      'material' => $this->material,
      'quantidade' => $this->quantidade,
      'descricao' => $this->descricao,
      'requisitado' => $this->getRequisitado(),
      'aceito' => $this->getAceito(),
    ]);
  }


  public function excluir()
  {
    return (new Banco('doacao'))->delete('id = ' . $this->id);
  }


  public static function doacaoPegar($where = null, $order = null, $limit = null, $field = '*')
  {
    return (new Banco('doacao'))->select($where,$order,$limit,$field);
  }


  public static function getDoacaoPorId($id) {
    return self::doacaoPegar('id = ' . $id)->fetchObject(self::class);
  }
}