<?php $title = "Mon portfolio - Connexion";
/** @var string $loginForm */
/** @var string $erreur */ ?>
<div class="card col-md-4 mx-auto my-4 p-4 shadow-sm bg-light">
    <h1 class="h3 mb-4 text-center">Connexion</h1>
    <?php if (!empty($erreur)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $erreur ?>
        </div>
    <?php } ?>
    <?= $loginForm ?>
</div>