<?php

use Phinx\Migration\AbstractMigration;

class Push extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function change()
    {
        $table = $this->table('push');
        $table
            ->addColumn('userId', 'integer')
            ->addColumn('authToken', 'string', ['length' => 255])
            ->addColumn('contentEncoding', 'string', ['length' => 255])
            ->addColumn('endpoint', 'text')
            ->addColumn('publicKey', 'text')
            ->addTimestamps('created', 'updated')
            ->addForeignKey('userId', 'users', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->create();
    }
}
