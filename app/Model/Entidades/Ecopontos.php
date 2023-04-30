<?php

namespace App\Model\Entidades;

use \App\Controller\Utilidades\Banco;

class Ecopontos
{
  public $id;

  public $id_usuario;

  public $endereco;

  public $tag;

  public $data;

  public function cadastrar()
  {
    // Modificar
    $this->id_usuario = 123;
    // Modificar
    $this->data = date('Y-m-d H:i:s');

    $this->id = (new Banco('ecopontos'))->insert([
      'id_usuario' => $this->id_usuario,
      'endereco' => $this->endereco,
      'tag' => $this->tag,
    ]);

    return true;
  }

  public static function ecopontosPegar($where = null, $order = null, $limit = null, $field = '*')
  {
    return (new Banco('ecopontos'))->select($where,$order,$limit,$field);
  }
}