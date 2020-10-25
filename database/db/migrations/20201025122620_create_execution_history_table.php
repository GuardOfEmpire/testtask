<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateExecutionHistoryTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('execution_history')
            ->addColumn('user_id', 'integer')
            ->addColumn('request_data', 'text')
            ->addColumn('response', 'integer')
            ->create();
    }
    
    public function down(): void
    {
        $this->table('execution_history')->drop()->save();
    }
}
