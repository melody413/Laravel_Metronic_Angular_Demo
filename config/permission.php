<?php

return [
    // admin premission
    'admin' => [
        [
            'group' => 'settings',
            'key' => 'settings',
            'permissions' => [
                [
                    'label' => 'edit',
                    'key' => 'edit',
                ],
            ],
        ],
        [
            'group' => 'Pages',
            'key' => 'page',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                        'hidden' => false
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'Faq',
            'key' => 'faq',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'Country',
            'key' => 'country',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'city',
            'key' => 'city',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'area',
            'key' => 'area',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'specialty',
            'key' => 'specialty',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'pharmacy',
            'key' => 'pharmacy',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'lab',
            'key' => 'lab',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'lab_service',
            'key' => 'lab_service',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'insurance_company',
            'key' => 'insurance_company',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'hospital',
            'key' => 'hospital',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'doctor',
            'key' => 'doctor',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'doctor_rate',
            'key' => 'doctor_rate',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],

                    [
                        'label' => 'Toggle Active',
                        'key' => 'toggleActive',
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                ]
        ],
        [
            'group' => 'doctor_branch',
            'key' => 'doctor_branch',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Store',
                        'key' => 'store',
                        'hidden' => true
                    ],
                    [
                        'label' => 'Create',
                        'key' => 'create',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Edit',
                        'key' => 'edit',
                        'relation' => 'store'
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                    [
                        'label' => 'Copy',
                        'key' => 'copy',
                        'hidden' => true
                    ],
                ]
        ],
        [
            'group' => 'reservation',
            'key' => 'reservation',
            'permissions' =>
                [
                    [
                        'label' => 'List',
                        'key' => 'index',
                    ],
                    [
                        'label' => 'Delete',
                        'key' => 'delete',
                    ],
                ]
        ],
        [
            'group' => 'role',
            'key' => 'role',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
                [
                    'label' => 'Copy',
                    'key' => 'copy',
                    'hidden' => true
                ],
            ],
        ],
        [
            'group' => 'user',
            'key' => 'user',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
                [
                    'label' => 'Copy',
                    'key' => 'copy',
                    'hidden' => true
                ],
            ],
        ],
        [
            'group' => 'log',
            'key' => 'log',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ],
        [
            'group' => 'center',
            'key' => 'center',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ],
        [
            'group' => 'hospital_type',
            'key' => 'hospital_type',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ],
        [
            'group' => 'medicine',
            'key' => 'medicine',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ],
        [
            'group' => 'medicines_company',
            'key' => 'medicines_company',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ],
        [
            'group' => 'medicines_sc_name',
            'key' => 'medicines_sc_name',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ],
        [
            'group' => 'tag',
            'key' => 'tag',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ],
        [
            'group' => 'sub_category',
            'key' => 'sub_category',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ],
        [
            'group' => 'qanswer',
            'key' => 'qanswer',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ],
        [
            'group' => 'medicines_category',
            'key' => 'medicines_category',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ],
        [
            'group' => 'disease',
            'key' => 'disease',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ],
        [
            'group' => 'body_part',
            'key' => 'body_part',
            'permissions' => [
                [
                    'label' => 'List',
                    'key' => 'index',
                ],
                [
                    'label' => 'Store',
                    'key' => 'store',
                    'hidden' => true
                ],
                [
                    'label' => 'Create',
                    'key' => 'create',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Edit',
                    'key' => 'edit',
                    'relation' => 'store'
                ],
                [
                    'label' => 'Delete',
                    'key' => 'delete',
                ],
            ],
        ]
    ]


];
