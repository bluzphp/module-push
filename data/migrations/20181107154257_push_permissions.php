<?php

use Phinx\Migration\AbstractMigration;

class PushPermissions extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $data = [
            [
                'roleId' => 2,
                'module' => 'push',
                'privilege' => 'Management'
            ],
            [
                'roleId' => 2,
                'module' => 'push',
                'privilege' => 'Subscribe'
            ],
            [
                'roleId' => 3,
                'module' => 'push',
                'privilege' => 'Subscribe'
            ],
        ];

        $privileges = $this->table('acl_privileges');
        $privileges->insert($data)
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM acl_privileges WHERE module = "push"');
    }
}
