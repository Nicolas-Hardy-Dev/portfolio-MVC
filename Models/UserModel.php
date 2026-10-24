<?php

namespace App\Models;

use App\Core\DbConnect;

class UserModel extends DbConnect
{
    public function findByUsername( string $username)
    {
        $this->request = $this->connection->prepare("SELECT * FROM portfolio_user WHERE username = :username");
        $this->request->execute([
            'username' => $username
        ]);
        $user = $this->request->fetch();
        return $user;
    }
}