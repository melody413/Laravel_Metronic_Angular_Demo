<?php
return [
    'assistant_save'     => [
        'head'  =>  'Assistant Added',
        'body'  =>  'Has been added successfully'
    ],
    'assistant_update'   =>  [
        'head'  =>  'Assistant Updated',
        'body'  =>  'Has been updated successfully'
    ],
    'assistant_delete'   =>  [
        'success'   =>  'Assistant has been deleted successfully',
        'fail'   =>  [
            'head'   => 'Cannot delete this assistant',
            'body'   => 'Selected assistant cannot delete. This assistant is used in appointment / patient'
        ]
    ]
];