<?php

namespace App\Controller\Utilidades;

class Ambiente{

  // Carrega as variáveis de ambiente do projeto
  public static function load($dir)
  {
    if (! file_exists($dir.'/.env')) {
      return false;
    }

    //Define variaveis do ambiente
    $lines = file($dir.'/.env');
    foreach ($lines as $line) {
      putenv(trim($line));
    }
  }
}