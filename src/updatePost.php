<?php

include_once("../constante.php");
include_once("../service/conexao.php");
include_once("../service/auth.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if (!empty($_POST['txtTituloPost']) && !empty($_POST['txtResumoPost']) && !empty($_POST['txtConteudoPost'])) {

        $postagemId = filter_input(INPUT_POST, "txtPostagemId", FILTER_SANITIZE_SPECIAL_CHARS);
        $titulo = filter_input(INPUT_POST, "txtTituloPost", FILTER_SANITIZE_SPECIAL_CHARS);
        $resumo = filter_input(INPUT_POST, "txtResumoPost", FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, "txtConteudoPost", FILTER_SANITIZE_SPECIAL_CHARS);
        $imgName = filter_input(INPUT_POST, "imgName", FILTER_SANITIZE_SPECIAL_CHARS);


        ## codigo para inserir imagem

        if (isset($_FILES["imgPost"]) && !empty($_FILES["imgPost"]["name"])) {
            $allowedTypes = ["image/png", "image/jpeg"];
            $fileType = mime_content_type($_FILES["imgPost"]["tmp_name"]);
            $ext = strtolower(pathinfo($_FILES["imgPost"]["name"], PATHINFO_EXTENSION));

            if (in_array($fileType, $allowedTypes) && ($ext == "jpg" || $ext == "jpeg" || $ext == "png")) {
                $nameFile = pathinfo($_FILES["imgPost"]["name"], PATHINFO_FILENAME);
                $imagem_url = hash("md5", $nameFile) . "." . $ext;
                $dir = DIR_PATH . "/img-posts/";
                move_uploaded_file($_FILES["imgPost"]["tmp_name"], $dir . $imagem_url);
            } else {
                $_SESSION['mensagem'] =  "Erro: Apenas arquivos JPG ou PNG são permitidos.";
                $_SESSION['cor'] = 'alert-danger';
                header("Location: " . ROOT_PATH . "screens/criarPost.php");
                exit;
            }
        } else {

            $imagem_url = $imgName;
        }

        // CODIGO PARA update

        try {
            $sql = "UPDATE posts SET titulo=:titulo, resumo=:resumo, descricao=:descricao, imagem=:imagem_url WHERE id_post = :postagemId";
            $update = $conexao->prepare($sql);
            $update->bindParam(":titulo", $titulo);
            $update->bindParam(":resumo", $resumo);
            $update->bindParam(":descricao", $descricao);
            $update->bindParam(":imagem_url", $imagem_url);
            $update->bindParam(":postagemId", $postagemId);


            if ($update->execute() && $update->rowCount()>0){

                $_SESSION['mensagem'] = "Cadastro com sucesso!";
                $_SESSION['cor'] = 'alert-success';
                header("Location: " . ROOT_PATH . "screens/postar.php");
                exit;

            } else {
                throw new Exception("Ocorreu um erro ao cadastrar!");
            }

        } catch (Exception $e) {
            $_SESSION['mensagem'] = "Ocorreu um erro!" . $e;
            $_SESSION['cor'] = 'alert-danger';
            header("Location: " . ROOT_PATH . "screens/editarPost.php");
            exit;
            
        } finally {
            unset($conexao);
        }

    } else {

        $_SESSION['mensagem'] = "Obrigatório preencher todos os campos";
        $_SESSION['cor'] = 'alert-danger';
        header("Location: " . ROOT_PATH . "screens/editarPost.php");
        exit;
    }
    
    
}

?>