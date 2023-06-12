<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TodoListSeeder extends Seeder
{
    public function run()
    {
        //seed some user todo data.
        $now   = date("Y-m-d H:i:s");

        $data = [
            [
                't_title'    => 'Example title2',
                't_content'  => 'Example content2',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        $this->db->table('TodoLists')->insertBatch($data);
    }
}
