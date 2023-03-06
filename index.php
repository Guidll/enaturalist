<?php
include 'app/Controller/UsuarioController.php';

// pega a url que o user esta acessando
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// echo $url;

switch($url)
{
  case '/':
    echo "página de inicial";
  break;
  case '/cadastro':
    UsuarioController::cadastro();
  break;
  case '/login':
    UsuarioController::login();
  break;
  default:
    echo "erro 404";
  break;
}
?>