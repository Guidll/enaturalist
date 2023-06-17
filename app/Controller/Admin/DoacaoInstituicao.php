<?php

namespace App\Controller\Admin;

use \PHPMailer\PHPMailer\PHPMailer as PHPMailer;
use \PHPMailer\PHPMailer\Exception as PHPMailerException;
use \League\OAuth2\Client\Grant\AuthorizationCode as Authorization;
use \League\OAuth2\Client\Provider\Google as ProviderGoogle;
use \League\OAuth2\Client\Provider\OAuth as ProviderOAuth;



use \App\Controller\Utilidades\View;
use \App\Controller\Paginas\Paginas;
use \App\Controller\Utilidades\Paginacao;
use \App\Model\Entidades\Doacao as EntidadeDoacao;
use \App\Model\Entidades\Usuario as EntidadeUsuario;

class DoacaoInstituicao extends Pagina
{
  // Retorna o conteúdo da view home
  public static function getDoacao($requisicao) {
    $conteudo = View::renderizar('admin/doacao-instituicao', [
      'itens' => self::doacaoItensPegar($requisicao, $objPaginacao),
      'paginacao' => Paginas::paginacaoPegar($requisicao, $objPaginacao),
    ]);

    return parent::getPainelInstituicao('Doação Instituições', $conteudo, 'doacao');
  }


  public static function setDoacao($requisicao)
  {
    $dadosPost = $requisicao->urlParametrosPostPegar();
    $objDoacao = new EntidadeDoacao;
    $objDoacao->material = $dadosPost['material'];
    $objDoacao->quantidade = $dadosPost['quantidade'];
    $objDoacao->cadastrar();

    return self::getDoacao($requisicao);
  }

  public static function getDoacaoEditar($requisicao, $id)
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);

    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
    }

    $conteudo = View::renderizar('admin/doacao/editar-instituicao', [
      'material' => $objDoacao->material,
      'quantidade' => $objDoacao->quantidade,
    ]);

    return parent::getPainel('Editar doacao', $conteudo, 'doacao');
  }


  public static function setDoacaoEditar($requisicao, $id)
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);

    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
    }

    $dadosPost = $requisicao->urlParametrosPostPegar();
    $objDoacao->material = $dadosPost['material'] ?? $objDoacao->material;
    $objDoacao->quantidade = $dadosPost['quantidade'] ?? $objDoacao->quantidade;
    $objDoacao->atualizar();

    $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao/' . $objDoacao->id . '/editar-instituicao');
  }


  public static function getDoacaoExcluir($requisicao, $id)
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);

    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
    }

    $conteudo = View::renderizar('admin/doacao/excluir-instituicao', [
      'material' => $objDoacao->material,
      'quantidade' => $objDoacao->quantidade,
    ]);

    return parent::getPainel('Excluir doacao', $conteudo, 'doacao');
  }


  public static function setDoacaoExcluir($requisicao, $id)
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);

    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
    }

    // $dadosPost = $requisicao->urlParametrosPostPegar();
    // $objDoacao->material = $dadosPost['material'] ?? $objDoacao->material;
    // $objDoacao->quantidade = $dadosPost['quantidade'] ?? $objDoacao->quantidade;
    $objDoacao->excluir($id);

    $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
  }

  private static function doacaoItensPegar($requisicao, &$objPaginacao)
  {
    $itens = '';

    $usuarioId = EntidadeUsuario::getUsuarioId($_SESSION['admin']['usuario']['id']);

    // $quantidadeTotal = EntidadeDoacao::doacaoPegar('id_usuario = ' . $usuarioId, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
    $quantidadeTotal = EntidadeDoacao::doacaoPegar(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

    $urlParametros = $requisicao->urlParametrosPegar();

    $paginaAtual = $urlParametros['pagina'] ?? 1;

    $objPaginacao = new Paginacao($quantidadeTotal, $paginaAtual, 3);

    // $resultado = EntidadeDoacao::doacaoPegar('id_usuario = ' . $usuarioId, 'id DESC', $objPaginacao->getLimit());
    $resultado = EntidadeDoacao::doacaoPegar(null, 'id DESC', $objPaginacao->getLimit());

    while($objDoacao = $resultado->fetchObject(EntidadeDoacao::class)) {
      $usuarioEndereco = EntidadeUsuario::getUsuarioEnderecoPorId($objDoacao->id_usuario);
      $usuarioCelular = EntidadeUsuario::getUsuarioCelularPorId($objDoacao->id_usuario);

      $itens .= View::renderizar('admin/doacao/itens-instituicao', [
        'id' => $objDoacao->id,
        'material' => $objDoacao->material,
        'quantidade' => $objDoacao->quantidade,
        'endereco' => $usuarioEndereco,
        'celular' => $usuarioCelular,
      ]);
    }

    return $itens;
  }


  public static function getDoacaoRequisitar($requisicao)
  {
    $url = $_SERVER['REQUEST_URI'];

    // Obter o caminho (path) da URL
    $path = parse_url($url, PHP_URL_PATH);

    // Extrair o número usando expressões regulares
    preg_match('/\/(\d+)\/requisitar$/', $path, $matches);
    $id = $matches[1];

    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);

    $id_usuario = $objDoacao->id_usuario;
    $objUsuario = EntidadeUsuario::getUsuarioPorId($id_usuario);

    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
    }

    $conteudo = View::renderizar('admin/doacao/requisitar', [
      'material' => $objDoacao->material,
      'quantidade' => $objDoacao->quantidade,
      'endereco' => $objUsuario->endereco,
      'celular' => $objUsuario->celular,
    ]);

    return parent::getPainel('requisitar doacao', $conteudo, 'doacao');
  }


  public static function setDoacaoRequisitar($requisicao)
  {
    $url = $_SERVER['REQUEST_URI'];

    // Obter o caminho (path) da URL
    $path = parse_url($url, PHP_URL_PATH);

    // Extrair o número usando expressões regulares
    preg_match('/\/(\d+)\/requisitar$/', $path, $matches);
    $id_doacao = $matches[1];

    $objDoacao = EntidadeDoacao::getDoacaoPorId($id_doacao);

    $id_usuario = $objDoacao->id_usuario;
    $objUsuario = EntidadeUsuario::getUsuarioPorId($id_usuario);
    $objUsuarioInstituicao = EntidadeUsuario::getUsuarioPorId($_SESSION['admin']['usuario']['id']);

    $mail = new PHPMailer();

    $mail->isSMTP();  // Define o uso do SMTP
    $mail->Host = 'smtp.gmail.com';  // Endereço do servidor SMTP
    $mail->Port = 587;  // Porta do servidor SMTP
    $mail->SMTPAuth = true;  // Ativa a autenticação SMTP
    $mail->Username = 'zguilherme2001oliveira@gmail.com';  // Seu endereço de e-mail
    $mail->Password = 'zuwshboywatccpud';  // Sua senha de e-mail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Sua senha de e-mail

    $mail->setFrom('zguilherme2001oliveira@gmail.com', 'eNaturalist');  // Endereço e nome do remetente
    $mail->addAddress($objUsuario->email, $objUsuario->nome);  // Endereço e nome do destinatário

    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);

    $mail->Subject = 'eNaturalist - Solicitação de doação';  // Assunto do e-mail
    $mail->Body = '<div style="font-size:16px">Boa tarde, ' . $objUsuario->nome . '.</div>
                   <br>
                   <div style="font-size:16px">A instituição ' . $objUsuarioInstituicao->nome . ', portadora do CNPJ:' . $objUsuarioInstituicao->cnpj .' está solicitando sua doação.</div>
                   <br>
                   <div style="font-size:16px">Material:' . $objDoacao->material . ' - Quantidade:' . $objDoacao->quantidade . '</div>
                   <br>
                   <div style="font-size:16px">Se for do seu interesse concluir a doação entre em contato com <span style="text-decoration:underline;">' . $objUsuarioInstituicao->celular . '</span></div>';  // Conteúdo do e-mail (pode ser HTML)

    if ($mail->send()) {
      echo 'E-mail enviado com sucesso.';
    } else {
        echo 'Falha ao enviar o e-mail.';
        echo 'Erro: ' . $mail->ErrorInfo;
    }

    $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
  }


  public static function getFiltroRequisitar($requisicao)
  {
    $url = $_SERVER['REQUEST_URI'];

    // Obter o caminho (path) da URL
    $path = parse_url($url, PHP_URL_PATH);

    // Extrair o número usando expressões regulares
    preg_match('/\/(\d+)\/requisitar$/', $path, $matches);
    $id = $matches[1];

    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);

    $id_usuario = $objDoacao->id_usuario;
    $objUsuario = EntidadeUsuario::getUsuarioPorId($id_usuario);

    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
    }

    $conteudo = View::renderizar('admin/doacao/requisitar', [
      'material' => $objDoacao->material,
      'quantidade' => $objDoacao->quantidade,
      'endereco' => $objUsuario->endereco,
      'celular' => $objUsuario->celular,
    ]);

    return parent::getPainel('requisitar doacao', $conteudo, 'doacao');
  }
}