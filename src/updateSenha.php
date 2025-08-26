<?php 

include_once("../constante.php");
include_once("../service/auth.php");
include_once("../service/conexao.php");

if ($_SERVER['REQUEST_METHOD']==='POST'){
    $idUserUpdate = filter_input(INPUT_POST, "txtIdUser", FILTER_SANITIZE_SPECIAL_CHARS);
    $novaSenhaUpdate = filter_input(INPUT_POST, "txtNovaSenha", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmarSenhaUpdate = filter_input(INPUT_POST, "txtConfirmarSenha", FILTER_SANITIZE_SPECIAL_CHARS);
}
try {
    $sql = "UPDATE usuarios SET senha=:novaSenhaUpdate WHERE id_usuario=:idUserUpdate";
    $updateSenha = $conexao->prepare($sql);
    $updateSenha->bindParam(":idUserUpdate", $idUserUpdate);
    $updateSenha->bindParam(":novaSenhaUpdate", $novaSenhaUpdate);

    if ($updateSenha->execute()){
        if ($novaSenhaUpdate !== $confirmarSenhaUpdate) {
            $_SESSION['mensagem'] = "As senhas não coincidem!";
            $_SESSION['cor'] = 'alert-warning';
            header("Location: " . ROOT_PATH . "screens/perfil.php");
            exit;
        }
        $_SESSION['mensagem'] = "Atualizado com sucesso";
        $_SESSION['cor'] = 'alert-success';
        header("Location: " . ROOT_PATH . "screens/perfil.php");
        exit;    
    } else {
        throw new Exception("Ocorreu um erro ao atualizar!");
    }
} catch (Exception $e) {
    $_SESSION['mensagem'] = "Ocorreu um erro ao atualizar!";
    $_SESSION['cor'] = 'alert-warning';
    header("Location: " . ROOT_PATH . "screens/perfil.php");
    exit;
} finally {
    unset($conexao);
}

?>