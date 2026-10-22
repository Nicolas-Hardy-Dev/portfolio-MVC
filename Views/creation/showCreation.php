<?php /** @var object $creation */
$title = "Mon portfolio - " . htmlspecialchars($creation->title, ENT_QUOTES); ?>
<article class="row justify-content-center text-center">
    <h1 class="col-12"><?= htmlspecialchars($creation->title, ENT_QUOTES) ?></h1>
    <p>Date de la publication: <?= date("d/m/Y", strtotime($creation->created_at))?></p>
    <img class="col-4" src="<?= htmlspecialchars($creation->picture, ENT_QUOTES) ?>" alt="<?= htmlspecialchars($creation->title, ENT_QUOTES) ?>">
    <p><?= htmlspecialchars($creation->description, ENT_QUOTES) ?></p>
</article>
