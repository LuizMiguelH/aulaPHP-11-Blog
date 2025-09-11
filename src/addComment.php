<?php

include_once("../constante.php");
include_once("../service/conexao.php");
include_once("../service/auth.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if (!empty($_POST['txtComment'])) {

        $comentario = filter_input(INPUT_POST, "txtComment", FILTER_SANITIZE_SPECIAL_CHARS);
        $idPost = filter_input(INPUT_POST, "idPost", FILTER_SANITIZE_SPECIAL_CHARS);
        $idUser = filter_input(INPUT_POST, "idUser", FILTER_SANITIZE_SPECIAL_CHARS);
        
        // CODIGO PARA INSERT

        try {
            $sql = "INSERT INTO comentarios (comentario, id_post, id_usuario) VALUES (:comentario, :idPost, :idUser)";
            $insert = $conexao->prepare($sql);
            $insert->bindParam(":comentario", $comentario);
            $insert->bindParam(":idPost", $idPost);
            $insert->bindParam(":idUser", $idUser);

            if ($insert->execute() && $insert->rowCount()>0){

                $_SESSION['mensagem'] = "Comentário enviado!";
                $_SESSION['cor'] = 'alert-success';
                header("Location: " . ROOT_PATH . "index.php");
                exit;

            } else {
                throw new Exception("Comentário não foi enviado!");
            }

        } catch (Exception $e) {
            $_SESSION['mensagem'] = "Ocorreu um erro!" . $e;
            $_SESSION['cor'] = 'alert-danger';
            header("Location: " . ROOT_PATH . "screens/criarPost.php");
            exit;
            
        } finally {
            unset($conexao);
        }

    } else {

        $_SESSION['mensagem'] = "Escreva algo para conseguir enviar!";
        $_SESSION['cor'] = 'alert-danger';
        header("Location: " . ROOT_PATH . "index.php");
        exit;
    }
    
    
}
?>