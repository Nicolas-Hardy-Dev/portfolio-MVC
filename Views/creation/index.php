<?php $title = "Mon portfolio - Liste de mes créations" ?>
<div class="card shadow-sm p-4 my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Liste de mes créations</h2>
        <!-- Suppression du <button> imbriqué dans le <a> (HTML invalide), remplacé par les classes bootstrap btn -->
        <?php if (isset($_SESSION['username'])) { ?>
        <a href="index.php?controller=creation&action=add" class="btn btn-primary">Ajouter une création</a>
        <?php } ?>
    </div>
    <table class="table table-hover table-striped table-bordered align-middle">
        <thead class="table-primary">
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col">Titre</th>
                <th scope="col">Description</th>
                <th scope="col" class="text-center">Date</th>
                <th scope="col" class="text-center">Image</th>
                <th scope="col" colspan="<?= isset($_SESSION['username']) ? 3 : 1 ?>" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php /** @var array $list */
            //On boucle dans le tableau $list qui contient la liste des créations
            foreach ($list as $value) {
                echo "<tr>";
                echo "<td class='text-center'>" . $value->id_creation . "</td>";
                echo "<td>" . htmlspecialchars($value->title, ENT_QUOTES) . "</td>";
                echo "<td>" . htmlspecialchars($value->description, ENT_QUOTES) . "</td>";
                echo "<td class='text-center'>" . date("d/m/Y", strtotime($value->created_at)) . "</td>";
                echo "<td class='text-center'><img src='" . htmlspecialchars($value->picture, ENT_QUOTES) . "' class='picture' alt='" . htmlspecialchars($value->title, ENT_QUOTES) . "'></td>";
                echo "<td class='text-center'><a href='index.php?controller=creation&action=showCreation&id=$value->id_creation' title='Voir la création'><i class='fas fa-eye'></i></a></td>";
                if (isset($_SESSION['username'])) {
                    echo "<td class='text-center'><a href='index.php?controller=creation&action=updateCreation&id=$value->id_creation' title='Modifier la création'><i class='fas fa-pen'></i></a></td>";
                    echo "<td class='text-center'><a href='index.php?controller=creation&action=deleteCreation&id=$value->id_creation' title='Supprimer la création'><i class='fas fa-trash-alt'></i></a></td>";   
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>