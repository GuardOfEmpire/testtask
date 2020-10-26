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
        /**
         * По хорошему надо бы шифровать пароли.
         * Но для тестового задания проще вносить в открытом виде (в том числе и для проверки)
         */
        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare("SELECT `id` FROM {$this->tableName} WHERE login = :login and password = :password");
        
        $stmt->execute(['login'=> $login, 'password' => $password]);

        return $stmt->fetchOne();
    }
}
