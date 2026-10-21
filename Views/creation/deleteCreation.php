<?php $title = "Mon portfolio - Suppression d'une création";
/** @var object $creation */ ?>
<div class="card col-md-6 mx-auto my-4 p-4 shadow-sm bg-light">
    <h1 class="h3 mb-4 text-center">Suppression d'une création</h1>
    <div class="alert alert-warning text-center mb-1" role="alert">
        <p>Voulez-vous supprimer la création : <strong><?= $creation->title ?></strong> ?</p>
        <form action="#" method="POST" class="d-flex justify-content-center gap-3">
            <input type="submit" value="OUI" name="true" class="btn btn-danger px-4">
            <input type="submit" value="NON" name="false" class="btn btn-primary px-4">
        </form>
    </div>
</div>