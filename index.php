<?php
include_once("./constante.php");
include_once("./includes/header.php");
include_once("./service/conexao.php");


$sqlPost = "SELECT * FROM posts";
$select = $conexao->prepare($sqlPost);
if ($select->execute()) {
    $postagens = $select->fetchAll(PDO::FETCH_ASSOC);

    
}
unset($conexao);
?>

<main>
    <div class="container d-flex justify-content-center flex-wrap">
        <?php foreach ($postagens as $post) { ?>
            <div class="card m-3 p-4">
                <?php if($post["imagem"] != null) {?>
                <img src="./img-posts/<?= $post["imagem"]?>" class="card-img-top shadow" alt="...">
                <?php }?>
                <div class="card-body">
                    <h5 class="card-title"><?= $post["titulo"]?></h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                </div>
            </div>
        <?php } ?>
    </div>
</main>

<?php
include_once("./includes/footer.php");
?>