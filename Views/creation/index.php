<?php $title = "Mon portfolio - Liste des mes créations" ?>
<h2>Liste de mes créations</h2>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">description</th>
            <th scope="col">created_at</th>
            <th scope="col">picture</th>
        </tr>
    </thead>
    <tbody>
        <?php /** @var array $list */
        //On boucle dans le tableau $list qui contient la liste des créations
        foreach ($list as $value) {
            echo "<tr>";
            echo "<td>" . $value['id'] . "</td>";
            echo "<td>" . $value['title'] . "</td>";
            echo "<td>" . $value['description'] . "</td>";
            echo "<td>" . $value['created_at'] . "</td>";
            echo "<td>" . $value['picture'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>