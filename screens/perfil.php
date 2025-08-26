<?php


include_once("../constante.php");
include_once("../includes/header.php");
include_once("../service/auth.php");
include_once("../service/conexao.php");

// Consulta BD para verificar se o usuario existe
$sql = "SELECT id_usuario, nome, email FROM usuarios WHERE id_usuario = :idUser";
$select = $conexao -> prepare($sql);
$select -> bindParam(":idUser", $idUser);

if ($select->execute() && $select->rowCount() >0) {
    $login = $select->fetch(PDO::FETCH_ASSOC);
}

unset($conexao);
?>

<main class="container mt-5">
    <form action="<?= ROOT_PATH ?>src/updatePerfil.php" method="post">
        <input type="text" id="idUser" name="txtIdUser" value="<?= $login['id_usuario'] ?>" class="form-control" hidden>
        <div class="mb-3">
            <label for="inputNone" value="">Nome</label>
            <input type="text" class="form-control" placeholder="Nome" name="txtNome" id="inputNome" value="<?= $login['nome'] ?>">
        </div>
        <div class="mb-3">
            <label for="inputNone" value="">Email</label>
            <input type="text" class="form-control" placeholder="email" name="txtEmail" id="inputEmail" value="<?= $login['email'] ?>">
        </div>
        <div>
            <button class="btn btn-sm btn-primary mb-2 w-10" type="submit"> Salvar Alteração</button>
        </div>
    </form>

    <form action="<?= ROOT_PATH ?>src/updateSenha.php" method="post">
        <input type="text" id="idUser" name="txtIdUser" value="" class="form-control" hidden>
        <div class="col-md-4">
            <label for="inputSenha1" value="">Nova Senha</label>
            <input type="password" class="form-control" name="txtNovaSenha" id="inputSenha1" value="">
        </div>
        <div class="col-md-4 mb-3">
            <label for="inputSenha2" value="">Confirmar Senha</label>
            <input type="password" class="form-control" name="txtConfirmarSenha" id="inputSenha2" value="">
        </div>

        <div>
            <button class="btn btn-sm btn-primary mb-2 w-10" type="submit"> Salvar Alteração</button>
        </div>
    </form>

    <div class="mt-5 cold-md-4">
        <?php
        
        if (isset($mensagem)) { ?>
            <p class="alert <?= $cor ?> mt-2"><?= $mensagem?></p>
        <?php
        }
        ?>
    </div>
</main>

<?php
include_once("../includes/footer.php");
?>