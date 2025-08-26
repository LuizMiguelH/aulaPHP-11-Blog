<?php 

include_once("../constante.php");
include_once("../service/conexao.php");
include_once("../service/auth.php");

if ($_SERVER['REQUEST_METHOD'] === "GET"){
    $postagemId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS);

    try {
        $sql = "DELETE FROM posts WHERE id_post = :postagemId";
        $delete = $conexao->prepare($sql);
        $delete->bindParam(":postagemId", $postagemId);

        if ($delete->execute()){
            $_SESSION['mensagem'] = "Excluido com Sucesso!";
            $_SESSION['cor'] = 'alert-success';
            header("Location: " . ROOT_PATH . "screens/postar.php");
        } else {
            throw new Exception("Ocorreu um erro");
        }
    } catch (Exception $e) {
        $_SESSION['mensagem'] = "Erro ao excluir";
        $_SESSION['cor'] = 'alert-danger';
        header("Location: " . ROOT_PATH . "screens/postar.php");
        exit;
    } finally {
        unset($conexao);     
    }
}
