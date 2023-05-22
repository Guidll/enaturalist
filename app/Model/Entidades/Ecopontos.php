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


  public static function ecopontosPegar($where = null, $order = null, $limit = null, $field = '*')
  {
    return (new Banco('ecopontos'))->select($where,$order,$limit,$field);
  }

  
  public static function getEcopontoPorId($id) {
    return self::ecopontosPegar('id = ' . $id)->fetchObject(self::class);
  }
}