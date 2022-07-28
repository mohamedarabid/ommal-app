    <?php
    // Aside menu

    use App\Http\Controllers\ControllersService;

    $adminIndex = [];
    $adminIndex = [
        'title' => 'list',
        'page' => 'cms/admin/admins',
    ];

    $adminCreate = [];

    $adminCreate = [
        'title' => 'create',
        'page' => 'cms/admin/admins/create'
    ];



    $roleIndex = [];

    $roleIndex = [
        'title' => 'list',
        'page' => 'cms/admin/roles',
    ];
    // }
    $roleCreate = [];

    $roleCreate = [
        'title' => 'create',
        'page' => 'cms/admin/roles/create'
    ];








    return [

        'items' => [
            // Dashboard
            [
                'title' => 'Dashboard ',
                'root' => true,
                'icon' => 'media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
                'page' => '/cms/admin',
                'new-tab' => false,
            ],

            // Custom
            [
                'section' => 'Admin Managment',
            ],


            [
                'title' => 'Roles',
                'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                'bullet' => 'line',
                'page' => '/cms/admin/roles',


            ],




            [
                'title' => 'Admin',
                'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                'bullet' => 'line',
                'root' => true,
                'page' => '/cms/admin/admins',

            ],

            [
                'title' => 'Worker',
                'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                'bullet' => 'line',
                'root' => true,
                'page' => '/cms/admin/worker',


            ],
            [
                'title' => 'Contractor',
                'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                'bullet' => 'line',
                'root' => true,
                'page' => '/cms/admin/contractor',


            ],
            [
                'title' => 'Work Type',
                'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                'bullet' => 'line',
                'root' => true,
                'page' => '/cms/admin/Work-Type',


            ],

            [
                'title' => 'City',
                'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                'bullet' => 'line',
                'root' => true,
                'page' => '/cms/admin/city',


            ],
             [
                'title' => 'SalaryType',
                'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                'bullet' => 'line',
                'root' => true,
                'page' => '/cms/admin/SalaryType',


            ],
            [
                'title' => 'currency',
                'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                'bullet' => 'line',
                'root' => true,
                'page' => '/cms/admin/currency',


            ],

        ]

    ];
