<?php

namespace App\Model\Entidades;

use \App\Controller\Utilidades\Banco;
use \App\Model\Entidades\Usuario as EntidadeUsuario;

class Ecopontos
{
  public $id;

  public $id_usuario;

  public $endereco;

  public $tag;

  public $data;

  // ----- ----------------------------
  // ----- Inicio metodos padroes -----
  // ----- ----------------------------
  public function __construct() {
    $this->data = date('Y-m-d H:i:s');
  }

  public function getId() {
    return $this->id;
  }
  public function setId($id) {
    $this->id = $id;
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


  public function cadastrar()
  {
    $this->id = (new Banco('ecopontos'))->insert([
      'id_usuario' => $_SESSION['admin']['usuario']['id'],
      'endereco' => $this->endereco,
      'tag' => $this->tag,
    ]);

    return true;
  }


  public function atualizar()
  {
    return (new Banco('ecopontos'))->update('id = '. $this->id, [
      'endereco' => $this->endereco,
      'tag' => $this->tag,
    ]);
  }


  public function excluir()
  {
    return (new Banco('ecopontos'))->delete('id = ' . $this->id);
  }


  public function setEcopontoEndereco($id) {
    return (new Banco('ecopontos'))->update('id = '. $this->id, [
      'endereco' => $id,
    ]);
  }


  public static function ecopontosPegar($where = null, $order = null, $limit = null, $field = '*')
  {
    return (new Banco('ecopontos'))->select($where,$order,$limit,$field);
  }


  public static function getEcopontoPorId($id) {
    return self::ecopontosPegar('id = ' . $id)->fetchObject(self::class);
  }


  public static function consultarEcopontoPorIdUsuario($id) {
    return self::ecopontosPegar('id_usuario = ' . $id)->fetchObject(self::class);
  }
}