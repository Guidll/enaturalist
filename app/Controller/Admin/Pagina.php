<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;

class Pagina
{
  // Modulos disponiveis do painel
  private static $modulos = [
    'home' => [
      'titulo' => 'Home',
      'link' => URL . '/admin',
    ],
    'ecopontos' => [
      'titulo' => 'Ecopontos',
      'link' => URL . '/admin/ecopontos',
    ],
    'doacao' => [
      'titulo' => 'Doar',
      'link' => URL . '/admin/doacao',
    ],
  ];

  // Modulos disponiveis do painel
  private static $modulos_instituicao = [
    'home' => [
      'titulo' => 'Home',
      'link' => URL . '/admin/instituicao',
    ],
    'ecopontos' => [
      'titulo' => 'Ecopontos',
      'link' => URL . '/admin/ecopontos-instituicao',
    ],
    'doacao' => [
      'titulo' => 'Doar',
      'link' => URL . '/admin/doacao-instituicao',
    ],
  ];

  public static function paginaPegar($titulo, $conteudo)
  {
    return View::renderizar('admin/pagina', [
      'titulo' => $titulo,
      'conteudo' => $conteudo,
    ]);
  }


  public static function getPainel($titulo, $conteudo, $moduloAtual)
  {
    $conteudoPainel = View::renderizar('admin/painel',[
      'menu' => self::getMenu($moduloAtual),
      'conteudo' => $conteudo,
    ]);

    return self::paginaPegar($titulo, $conteudoPainel);
  }


  private static function getMenu($moduloAtual)
  {
    $links = '';

    foreach (self::$modulos as $hash=>$modulo) {
      $links .= View::renderizar('admin/menu/link', [
        'titulo' => $modulo['titulo'],
        'link' => $modulo['link'],
        'atual' => $hash == $moduloAtual ? 'font-bold text-blue-500' : '',
      ]);
    }

    return View::renderizar('admin/menu/navegacao', [
      'links' => $links,
    ]);
  }


  public static function getPainelInstituicao($titulo, $conteudo, $moduloAtual)
  {
    $conteudoPainel = View::renderizar('admin/painel',[
      'menu' => self::getMenuInstituicao($moduloAtual),
      'conteudo' => $conteudo,
    ]);

    return self::paginaPegar($titulo, $conteudoPainel);
  }


  private static function getMenuInstituicao($moduloAtual)
  {
    $links = '';

    foreach (self::$modulos_instituicao as $hash=>$modulo) {
      $links .= View::renderizar('admin/menu/link', [
        'titulo' => $modulo['titulo'],
        'link' => $modulo['link'],
        'atual' => $hash == $moduloAtual ? 'font-bold text-blue-500' : '',
      ]);
    }

    return View::renderizar('admin/menu/navegacao', [
      'links' => $links,
    ]);
  }
}

