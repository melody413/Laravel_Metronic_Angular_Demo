<?php
return [
    'appointment_save'     => [
        'head'  =>  'Appointment Saved Successfully',
        'body'  =>  'Appointment has been saved successfully'
    ],
    'appointment_update'   =>  [
        'head'  =>  'Appointment Saved Successfully',
        'body'  =>  'Appointment has been saved successfully'
    ],
    'appointment_date_not_valid'=>[
        'head'  =>  'Appointment Date not valid',
        'body'  =>  'The date you entered in not valid. Doctor do not visit patient in this place on this day'
    ],
    'appointment_delete'   =>  [
        'success'   =>  'Assistant has been deleted successfully',
        'fail'   =>  [
            'head'   => 'Cannot delete this assistant',
            'body'   => 'Selected assistant cannot delete. This assistant is used in appointment / patient'
        ]
    ]
];