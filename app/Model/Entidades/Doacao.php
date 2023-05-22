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


  public function cadastrar()
  {
    $this->data = date('Y-m-d H:i:s');

    $this->id = (new Banco('doacao'))->insert([
      'id_usuario' => $_SESSION['admin']['usuario']['id'],
      'material' => $this->material,
      'quantidade' => $this->quantidade,
    ]);

    return true;
  }


  public function atualizar()
  {
    return (new Banco('doacao'))->update('id = '. $this->id, [
      'material' => $this->material,
      'quantidade' => $this->quantidade,
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