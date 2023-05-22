<?php

namespace App\Model\Entidades;

use \App\Controller\Utilidades\Banco;
use \App\Model\Entidades\Usuario;

class Instituicao extends Usuario
{
  public $cnpj;


  public static function instituicaoPorEmailSelecionar($email)
  {
    return (new Banco('instituicoes'))->select('email = "' . $email . '"')->fetchObject(self::class);
  }


  public static function getInstituicao($where = null, $order = null, $limit = null, $field = '*')
  {
    return (new Banco('instituicoes'))->select($where,$order,$limit,$field);
  }


  public function setInstituicao()
  {
    $this->id = (new Banco('instituicoes'))->insert([
      'nome' => $this->nome,
      'email' => $this->email,
      'senha' => $this->senha,
      'celular' => $this->celular,
      'endereco' => $this->endereco,
      'cnpj' => $this->cnpj,
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
}