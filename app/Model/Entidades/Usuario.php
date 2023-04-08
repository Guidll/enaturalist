<?php

namespace App\Model\Entidades;

class Usuario
{
  public $id = 1;

  public $nome = 'Guilherme';

  // 0 == restrito
  // 1 == total
  public $acesso = 0;
}