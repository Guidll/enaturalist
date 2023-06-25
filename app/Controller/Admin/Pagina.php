<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Model\Entidades\Doacao as EntidadeDoacao;

class Pagina
{
  // Modulos disponiveis do painel
  public static $modulos = [
    'home' => [
      'titulo' => 'Home',
      'link' => URL . '/admin',
      'solicitacao' => '',
    ],
    'ecopontos' => [
      'titulo' => 'Ecopontos',
      'link' => URL . '/admin/ecopontos',
      'solicitacao' => '',
    ],
    'doacao' => [
      'titulo' => 'Doar',
      'link' => URL . '/admin/doacao',
      'solicitacao' => '',
    ],
  ];

  // Modulos disponiveis do painel
  private static $modulos_instituicao = [
    'home' => [
      'titulo' => 'Home',
      'link' => URL . '/admin/instituicao',
    ],
    'ecopontos' => [
      'titulo' => 'Cadastrar Ecopontos',
      'link' => URL . '/admin/ecopontos-instituicao',
    ],
    'doacao' => [
      'titulo' => 'Doações',
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

    $quantidadeSolicitacao = self::verificarSolicitacao();
    self::$modulos['doacao']['solicitacao'] = $quantidadeSolicitacao;

    foreach (self::$modulos as $hash=>$modulo) {
      $links .= View::renderizar('admin/menu/link', [
        'titulo' => $modulo['titulo'],
        'link' => $modulo['link'],
        'atual' => $hash == $moduloAtual ? 'font-bold text-blue-500' : '',
        'solicitacao' => $modulo['solicitacao'],
        'solicitacao-exibir' => $modulo['titulo'] == 'Doar' && $quantidadeSolicitacao != 0 ? '' : 'hidden',
      ]);
    }

    return View::renderizar('admin/menu/navegacao', [
      'links' => $links,
      'usuario' => $_SESSION['admin']['usuario']['nome'],
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
      $links .= View::renderizar('admin/menu/link-instituicao', [
        'titulo' => $modulo['titulo'],
        'link' => $modulo['link'],
        'atual' => $hash == $moduloAtual ? 'font-bold text-blue-500' : '',
      ]);
    }

    return View::renderizar('admin/menu/navegacao', [
      'links' => $links,
      'usuario' => $_SESSION['admin']['usuario']['nome'],
    ]);
  }


  public static function verificarSolicitacao() {
    $id_usuario = $_SESSION['admin']['usuario']['id'];
    $resultado = EntidadeDoacao::doacaoPegar("$id_usuario AND requisitado = 1 AND aceito = 0");
    $contador_solicitacao = 0;

    while($objDoacao = $resultado->fetchObject(EntidadeDoacao::class)) {
      $contador_solicitacao++;
    }

    return $contador_solicitacao;
  }
}

