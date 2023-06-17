<?php

namespace App\Model\Entidades;

use \App\Controller\Utilidades\Banco;
use \App\Model\Entidades\Doacao;

class Solicitacao extends Doacao
{
  public $id;

  public $id_usuario;

  public $material;

  public $quantidade;

  public $data;

  public function cadastrar()
  {
    $this->data = date('Y-m-d H:i:s');

    $this->id = (new Banco('doacao'))->insert([
      'id_usuario' => $_SESSION['admin']['usuario']['id'],
      'material' => $this->material,
      'quantidade' => $this->quantidade,
      'data' => $this->data,
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
    return (new Banco('solicitacao'))->delete('id = ' . $this->id);
  }


  public static function getSolicitacao($where = null, $order = null, $limit = null, $field = '*')
  {
    return (new Banco('solicitacao'))->select($where,$order,$limit,$field);
  }


  public static function getSolicitacaoPorId($id) {
    return self::doacaoPegar('id = ' . $id)->fetchObject(self::class);
  }
}