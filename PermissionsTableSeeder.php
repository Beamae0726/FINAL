<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'reliable_source_create',
            ],
            [
                'id'    => 18,
                'title' => 'reliable_source_edit',
            ],
            [
                'id'    => 19,
                'title' => 'reliable_source_show',
            ],
            [
                'id'    => 20,
                'title' => 'reliable_source_delete',
            ],
            [
                'id'    => 21,
                'title' => 'reliable_source_access',
            ],
            [
                'id'    => 22,
                'title' => 'article_access',
            ],
            [
                'id'    => 23,
                'title' => 'category_create',
            ],
            [
                'id'    => 24,
                'title' => 'category_edit',
            ],
            [
                'id'    => 25,
                'title' => 'category_show',
            ],
            [
                'id'    => 26,
                'title' => 'category_delete',
            ],
            [
                'id'    => 27,
                'title' => 'category_access',
            ],
            [
                'id'    => 28,
                'title' => 'article_collection_create',
            ],
            [
                'id'    => 29,
                'title' => 'article_collection_edit',
            ],
            [
                'id'    => 30,
                'title' => 'article_collection_show',
            ],
            [
                'id'    => 31,
                'title' => 'article_collection_delete',
            ],
            [
                'id'    => 32,
                'title' => 'article_collection_access',
            ],
            [
                'id'    => 33,
                'title' => 'offensive_word_create',
            ],
            [
                'id'    => 34,
                'title' => 'offensive_word_edit',
            ],
            [
                'id'    => 35,
                'title' => 'offensive_word_show',
            ],
            [
                'id'    => 36,
                'title' => 'offensive_word_delete',
            ],
            [
                'id'    => 37,
                'title' => 'offensive_word_access',
            ],
            [
                'id'    => 38,
                'title' => 'block_ip_create',
            ],
            [
                'id'    => 39,
                'title' => 'block_ip_edit',
            ],
            [
                'id'    => 40,
                'title' => 'block_ip_show',
            ],
            [
                'id'    => 41,
                'title' => 'block_ip_delete',
            ],
            [
                'id'    => 42,
                'title' => 'block_ip_access',
            ],
            [
                'id'    => 43,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
