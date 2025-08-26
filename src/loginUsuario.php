<?php 

include_once("../constante.php");
include_once("../service/conexao.php");



if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (!empty($_POST['txtEmail']) && !empty($_POST['txtSenha'])){
        try {
            $email = filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_EMAIL);
            $senha = filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_SPECIAL_CHARS);
            
            // CONSULTAR AO BANCO DE DADOS VERIFICAR EMAIL
            $sql = "SELECT email, senha, nome, id_usuario FROM usuarios WHERE email = :email";
            $select = $conexao->prepare($sql);
            $select->bindParam(':email', $email);
            if($select->execute() && $select->rowCount() > 0){
                $login = $select->fetch(PDO::FETCH_ASSOC);
            
            
                if ($login['email'] && password_verify($senha, $login['senha'])){
                    $_SESSION['logado'] = true;
                    $_SESSION['idUser'] = $login['id_usuario'];
                    $_SESSION['nameUser'] = $login['nome'];

                    if ($login['is_admin'] === "admin"){
                        header("Location: " . ROOT_PATH . "screens/admin.php");
                        exit;
                    } else {
                        header("Location: " . ROOT_PATH . "index.php");
                        exit;
                    }
                }
            }
            $_SESSION['mensagem'] = "Usuario/senha inválidos";
            $_SESSION['cor'] = 'alert-danger';
            header("Location: " . ROOT_PATH . "screens/login.php");
            exit;

        } catch (Exception $e) {
            $_SESSION['mensagem'] = "Ocorreu um erro no Banco de Dados";
            $_SESSION['cor'] = 'alert-danger';
            header("Location: " . ROOT_PATH . "screens/login.php");
            exit;

        } finally {
            unset($conexao);
        }

    } else {
        $_SESSION['mensagem'] = "Obrigatório preencher todos os campos";
        $_SESSION['cor'] = 'alert-danger';
        header("Location: " . ROOT_PATH . "screens/login.php");
        exit;
    }
}


?>