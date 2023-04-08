<?php
require __DIR__ . '/vendor/autoload.php';

use \App\Http\Roteador;
use \App\Controller\Utilidades\View;

define('URL', 'http://localhost/enaturalist');

View::iniciar([
  'URL' => URL
]);

$objetoRoteador = new Roteador(URL);

// Inclui o gerenciamento de conteudo das rotas
include __DIR__ . '/rotas/Paginas.php';

// Exibi o conteuda da rota acessada
$objetoRoteador->executar()->respostaEnviar();
?>