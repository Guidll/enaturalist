<?php

namespace App\Model\Entidades;

use \App\Controller\Utilidades\Banco;
use \App\Model\Entidades\Usuario as EntidadeUsuario;
use \App\Model\Entidades\Doacao as EntidadeDoacao;
use \App\Model\Entidades\Instituicao as EntidadeInstituicao;

class Solicitacao {
  private $id;

  private $id_usuario;

  private $id_instituicao;

  private $id_doacao;

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


  public function getIdInstituicao() {
    return $this->id_instituicao;
  }
  public function setIdInstituicao($id_instituicao) {
    $this->id_instituicao = $id_instituicao;
  }


  public function getIdDoacao() {
    return $this->id_doacao;
  }
  public function setIdDoacao($id_doacao) {
    $this->id_doacao = $id_doacao;
  }


  public function getData() {
    return $this->data;
  }
  public function setData($dataValor) {
    $this->data = $dataValor;
  }


  // ----------------
  // ----- CRUD -----
  // ----------------
  public function cadastrar() {
    $this->setId((new Banco('solicitacoes'))->insert([
      'id_usuario' => $this->getIdUsuario(),
      'id_instituicao' => $this->getIdInstituicao(),
      'id_doacao' => $this->getIdDoacao(),
      'data' => $this->getData(),
    ]));

    return true;
  }


  public function atualizar() {
    return (new Banco('solicitacoes'))->update('id = '. self::getId(), [
      'id_usuario' => $this->getIdUsuario(),
      'id_instituicao' => $this->getIdInstituicao(),
      'id_doacao' => $this->getIdDoacao(),
    ]);
  }


  public function excluir() {
    return (new Banco('solicitacoes'))->delete('id = ' . $this->getId());
  }


  // --------------------------------------
  // ----- Consulta no banco de dados -----
  // --------------------------------------
  public static function consultarSolicitacao($where = null, $order = null, $limit = null, $field = '*') {
    return (new Banco('solicitacoes'))->select($where,$order,$limit,$field);
  }


  public static function consultarSolicitacaoPorId($id) {
    return self::consultarSolicitacao('id = ' . $id)->fetchObject(self::class);
  }


  public static function consultarSolicitacaoPorIdUsuario($id_usuario) {
    return self::consultarSolicitacao('id_usuario = ' . $id_usuario)->fetchObject(self::class);
  }


  public static function consultarSolicitacaoPorIdDoacao($id_doacao) {
    return self::consultarSolicitacao('id_doacao = ' . $id_doacao)->fetchObject(self::class);
  }
}