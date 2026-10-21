<?php $title = "Mon portfolio - Liste de mes créations" ?>
<div class="card shadow-sm p-4 my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Liste de mes créations</h2>
        <!-- Suppression du <button> imbriqué dans le <a> (HTML invalide), remplacé par les classes bootstrap btn -->
        <a href="index.php?controller=creation&action=add" class="btn btn-primary">Ajouter une création</a>
    </div>
    <table class="table table-hover table-striped table-bordered align-middle">
        <thead class="table-primary">
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col">Titre</th>
                <th scope="col">Description</th>
                <th scope="col" class="text-center">Date</th>
                <th scope="col" class="text-center">Image</th>
            </tr>
        </thead>
        <tbody>
            <?php /** @var array $list */
            //On boucle dans le tableau $list qui contient la liste des créations
            foreach ($list as $value) {
                echo "<tr>";
                echo "<td class='text-center'>" . $value->id_creation . "</td>";
                echo "<td>" . $value->title . "</td>";
                echo "<td>" . $value->description . "</td>";
                echo "<td class='text-center'>" . $value->created_at . "</td>";
                echo "<td class='text-center'><img src='$value->picture' class='picture' alt='$value->title'></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>