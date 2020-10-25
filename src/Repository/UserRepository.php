<?php

namespace App\Repository;

/**
 * Репозиторий пользователей
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    private $tableName = 'user';

    public function auth($login, $password)
    {
        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare("SELECT `id` FROM {$this->tableName} WHERE login = :login and password = :password");
        
        $stmt->execute(['login'=> $login, 'password' => $password]);

        return $stmt->fetchOne();
    }
}
