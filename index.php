<?php
// --- <Includes> ---
require __DIR__ . '/vendor/autoload.php';

use \App\Http\Roteador;
use \App\Controller\Utilidades\View;
use \App\Controller\Utilidades\Ambiente;
use \App\Controller\Utilidades\Banco;



// Carrega variaveis de ambiente
Ambiente::load(__DIR__);

define('URL', getenv('URL'));

View::iniciar([
  'URL' => URL
]);

Banco::config(
  getenv('DB_HOST'),
  getenv('DB_NAME'),
  getenv('DB_USER'),
  getenv('DB_PASS'),
  getenv('DB_PORT'),
);
// --- </Includes> ---



// --- <Execucao> ---
$objetoRoteador = new Roteador(URL);

// Inclui o gerenciamento de conteudo das rotas
include __DIR__ . '/rotas/Paginas.php';

// Exibi o conteuda da rota acessada
$objetoRoteador->executar()->respostaEnviar();
// --- </Execucao> ---