<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddNewUser extends AbstractMigration
{
    public function up(): void
    {
        $this->table('user')
            ->insert([
                'login' => 'user1',
                'password' => 'pass1',
            ])
            ->saveData();
    }
    
    public function down(): void
    {
        $this->execute('DELETE FROM user WHERE login="user1"');
    }
}
