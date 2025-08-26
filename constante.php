<?php 
define('DIR_PATH', realpath(dirname(__FILE__)));
define('ROOT_PATH', 'http://172.17.34.253:1200/projetos/202400005/PHP/luizmiguel_php/aulaPHP-11-Blog/');


//garante que a sessao esteja habilitada
if (session_start()===PHP_SESSION_NONE){
    session_start();
}

// inicializar as variaveis  de sessao
$mensagem = $_SESSION['mensagem'] ?? null;
$cor = $_SESSION['cor'] ?? null;
unset($_SESSION['mensagem']);
unset($_SESSION['cor']);

// variaveis logado

$logado = $_SESSION['logado'] ?? FALSE;
$idUser = $_SESSION['idUser'] ?? "";
$nameUser = $_SESSION['nameUser'] ?? "";