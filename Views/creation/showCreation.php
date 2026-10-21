<?php /** @var object $creation */
$title = "Mon portfolio - " . $creation->title; ?>
<article class="row justify-content-center text-center">
    <h1 class="col-12"><?= $creation->title ?></h1>
    <p>Date de la publication: <?= date("d/m/Y", strtotime($creation->created_at))?></p>
    <img class="col-4" src="<?= $creation->picture ?>" alt="<?= $creation->title ?>">
    <p><?= $creation->description ?></p>
</article>
