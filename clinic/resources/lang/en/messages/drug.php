<?php

return [
    'drug_save'     => [
        'head'  =>  'Drug Added',
        'body'  =>  'Has been added successfully'
    ],
    'drug_update'   =>  [
        'head'  =>  'Drug Updated',
        'body'  =>  'Has been updated successfully'
    ],
    'drug_delete'   =>  [
        'success'   =>  'Drug has been deleted successfully',
        'fail'   =>  [
            'head'   => 'Cannot delete this drug',
            'body'   => 'Selected drug cannot delete. This drug is used in prescription / prescription Template'
        ]
    ]
];