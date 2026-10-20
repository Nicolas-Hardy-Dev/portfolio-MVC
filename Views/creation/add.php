<?php $title = "Mon portfolio - Ajout d'une création";
/** @var string $addForm */
/** @var string $erreur */ ?>
<div class="card col-md-6 mx-auto my-4 p-4 shadow-sm bg-light">
    <h1 class="h3 mb-4 text-center">Ajout d'une création</h1>
    <?php if (!empty($erreur)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $erreur ?>
        </div>
    <?php } ?>
    <?= $addForm ?>
</div>