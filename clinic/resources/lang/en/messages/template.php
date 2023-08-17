<?php
return [
    'template_save'     => [
        'head'  =>  'Template Added',
        'body'  =>  'Template has been added successfully'
    ],
    'template_update'   =>  [
        'head'  =>  'Template Updated',
        'body'  =>  'Template updated successfully'
    ],
    'template_delete'   =>  [
        'success'   =>  'Template has been deleted successfully',
        'fail'   =>  [
            'head'   => 'Cannot delete this Template',
            'body'   => 'This template is used in prescription'
        ]
    ]
];