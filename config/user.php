<?php

return [
    'default_user' => [
        'super_admin' => [
            'id' => '6bdc93eb-f3a6-4021-a655-041809e11e01',
            'role_name' => 'Super Admin',
            'username' => env('USER_SUPER_ADMIN_USERNAME', 'admin@test.com'),
            'password' => env('USER_SUPER_ADMIN_PASSWORD', '12345'),
        ],
        'system_admin' => [
            'id' => '9186e2b7-beac-49c3-bc82-54962599e93f',
            'role_name' => 'System Admin',
            'username' => env('USER_SYSTEM_ADMIN_USERNAME', 'system@test.com'),
            'password' => env('USER_SYSTEM_ADMIN_PASSWORD', '12345'),
        ],
    ],

    'default_role' => [
        'super_admin' => ['id' => '6bdc93eb-f3a6-4021-a655-041809e11e01', 'name' => 'Super Admin'],
        'admin' => ['id' => '5ebd334d-5c6d-49be-9dc1-59f3ecfb087e', 'name' => 'Administrator'], // company administrator
        'branch_manager' => ['id' => '8e4ac365-be59-4a17-9d77-9f8f81a70374', 'name' => 'Branch Manager'],
        'team_leader' => ['id' => '82d3d703-0037-410b-9ebd-0ca4b6878e23', 'name' => 'Team Leader'],
        'agent' => ['id' => '94bdc4f2-781b-4e8f-a567-c97446b19b16', 'name' => 'Agent'],
    ],
];
