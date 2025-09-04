<?php
include_once("./constante.php");
include_once("./includes/header.php");
include_once("./service/conexao.php");


$sqlPost = "SELECT p.*, u.nome FROM posts p INNER JOIN usuarios u ON p.id_usuario = u.id_usuario ORDER BY p.id_post DESC";
$select = $conexao->prepare($sqlPost);
if ($select->execute()) {
    $postagens = $select->fetchAll(PDO::FETCH_ASSOC);
}
?>

<main>
    <div class="container d-flex justify-content-center flex-wrap col-xl-4">
        <?php foreach ($postagens as $post) { ?>
            <div class="card p-4 rounded-0">
                <div class="card-header d-flex bg-white m-0 mb-3 p-0 border-0">
                    <i class="bi bi-person-circle fs-1"></i>
                    <div class="name-and-date d-flex justify-content-between w-100">
                        <p class="h3 d-flex m-0 ms-3 align-items-center"><?= $post["nome"] ?></p>
                        <p class="d-flex m-0 ms-3 align-items-center">
                            <?= htmlspecialchars(date('H:m d/m/Y', strtotime($post["data_post"]))) ?></p>
                    </div>
                </div>
                <?php if ($post["imagem"] != null) { ?>
                    <img src="./img-posts/<?= $post["imagem"] ?>" class="card-img-top" alt="...">
                <?php } ?>
                <div class="card-body">
                    <h5 class="card-title"><?= $post["titulo"] ?></h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card’s content.</p>
                </div>
                <div class="card-footer bg-white d-flex flex-row border-0">
                    <i class="bi bi-heart fs-2 me-3" id="<?= $post["id_post"] ?>"></i>
                    <i class="bi bi-heart-fill fs-2 me-3" style="display: none;"></i>
                    <div class="d-flex w-100">
                        <label for="txtComment" class="form-label"></label>
                        <textarea type="text" class="form-control w-100 align-content-center" id="txtComment"
                            name="txtConteudoPost" rows="1" placeholder="Adicionar Comentário"></textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="verMais text-primary mt-2">Ver comentários</p>
                </div>
                <div class="comentarios bg-black">
                    <?php $sqlComment = "SELECT c.*, u.nome FROM comentarios c 
                    INNER JOIN usuarios u ON c.id_usuario = u.id_usuario 
                    INNER JOIN posts p ON c.id_post = p.id_post 
                    WHERE c.id_post = $post['id_post']
                    ORDER BY c.id_comentario DESC";
                    $selecionar = $conexao->prepare($sqlComment);
                    if ($selecionar->execute()) {
                        $comentarios = $selecionar->fetchAll(PDO::FETCH_ASSOC);
                    }
                    unset($conexao);
                    foreach ($comentarios as $comment) { ?>
                        <div class="card p-2 rounded-1">
                            <div class="name-and-date d-flex justify-content-between w-100">
                                <p class="h3 d-flex m-0 ms-3 align-items-center"><?= $comment["nome"] ?></p>
                                <p class="d-flex m-0 ms-3 align-items-center">
                                    <?= htmlspecialchars(date('H:m d/m/Y', strtotime($comment["data_comentario"]))) ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</main>

<?php
include_once("./includes/footer.php");
?>