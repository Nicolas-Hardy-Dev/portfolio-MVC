<?php $title = "Mon portfolio - Modification d'une création";
/** @var string $updateForm */
/** @var string $erreur */
/** @var string $picture */ 
/** @var string $titleCreation */ ?>
<div class="card col-md-6 mx-auto my-4 p-4 shadow-sm bg-light">
    <h1 class="h3 mb-4 text-center">Modification d'une création</h1>
    <?php if (!empty($erreur)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $erreur ?>
        </div>
    <?php } ?>
    
    <section class="row">
        <div class="col-2 align-self-end"><img class="img-fluid" src="<?= htmlspecialchars($picture, ENT_QUOTES) ?>" alt="<?= htmlspecialchars($titleCreation, ENT_QUOTES) ?>"></div>
        <div class="col-10"><?= $updateForm ?></div>
    </section>
</div>