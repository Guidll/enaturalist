<?php

namespace App\Controller\Utilidades;

class View
{
  private static $vars = [];

  public static function iniciar($vars = [])
  {
    self::$vars = $vars;
  }

  // Retorna a página view caso ela exista (arquivo html)
  private static function viewPegar($view)
  {
    $arquivo = __DIR__ . '/../../../src/view/' . $view . '.html';

    return file_exists($arquivo) ? file_get_contents($arquivo) : '';
  }

  // Retorna o conteúdo da view (html e dados)
  public static function renderizar($view, $dados = [])
  {
    $view_conteudo = self::viewPegar($view);

    // Junta o array dados da classe com os dados da view
    $dados_finais = array_merge(self::$vars, $dados);

    $dados_processados = array_keys($dados_finais);
    $dados_processados = array_map(function($item){
      return '{{' . $item . '}}';
    }, $dados_processados);

    return str_replace($dados_processados,array_values($dados_finais), $view_conteudo);
  }
}