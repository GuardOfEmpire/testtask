<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('user')
            ->addColumn('login', 'string', ['limit' => 20])
            ->addColumn('password', 'string', ['limit' => 40])
            ->addIndex(['login'], ['unique' => true])
            ->create();
    }
    
    public function down(): void
    {
        $this->table('user')->drop()->save();
    }
}
