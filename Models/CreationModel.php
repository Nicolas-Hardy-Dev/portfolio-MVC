<?php

namespace App\Models;

use Exception;
use App\Core\DbConnect;
use App\Entities\Creation;

class CreationModel extends DbConnect
{
    public function findAll()
    {
        $this->request = "SELECT * FROM creation";
        $result = $this->connection->query($this->request);
        $list = $result->fetchAll();
        return $list;
    }

    public function find(int $id)
    {
        $this->request = $this->connection->prepare("SELECT * FROM creation WHERE id_creation = :id_creation");
        $this->request->execute([
            'id_creation' => $id
        ]);
        $creation = $this->request->fetch();
        return $creation;
    }

    public function create(Creation $creation)
    {
        $this->request = $this->connection->prepare("INSERT INTO creation VALUES (NULL, :title, :description, :created_at, :picture)");
        $this->request->bindValue(":title", $creation->getTitle());
        $this->request->bindValue(":description", $creation->getDescription());
        $this->request->bindValue(":created_at", $creation->getCreated_at());
        $this->request->bindValue(":picture", $creation->getPicture());
        $this->executeTryCatch();
    }

    public function update(int $id, Creation $creation)
    {
        $this->request = $this->connection->prepare("UPDATE creation 
                                                    SET title = :title, description = :description, created_at = :created_at, picture = :picture
                                                    WHERE :id_creation = id_creation");
        $this->request->bindValue(":id_creation", $id);
        $this->request->bindValue(":title", $creation->getTitle());
        $this->request->bindValue(":description", $creation->getDescription());
        $this->request->bindValue(":created_at", $creation->getCreated_at());
        $this->request->bindValue(":picture", $creation->getPicture());
        $this->executeTryCatch();
    }

    public function delete(int $id)
    {
        $this->request = $this->connection->prepare("DELETE FROM creation WHERE id_creation = :id_creation");
        $this->request->bindValue(":id_creation", $id);
        $this->executeTryCatch();
    }

    private function executeTryCatch()
    {
        try {
            $this->request->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        // "Ferme" cette requête et permet que la connexion soit disponible pour la suivante.
        $this->request->closeCursor();
    }
}