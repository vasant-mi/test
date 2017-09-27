<?php

return [
    'signup' => [
        'v1' => [
            'rules' => [
                'username' => 'required',
                'password' => 'required|min:6',
                'email' => [
                    'required',
                    'email',
                    \Illuminate\Validation\Rule::unique('users')->where(function ($query) {
                        /** @var \Illuminate\Database\Query\Builder $query */
                        $query->where('status_id', '!=', \App\Status::$DELETED);
                    })
                ],
                'country_id' => 'required|integer|exists:country,id',
                'newsletter' => 'required|in:Yes,No',
                'date_of_birth' => 'required|date|before:today',
            ],
            'messages' => [
                'username.required' => 'Please enter your name.',
                'password.required' => 'Please enter password.',
                'password.min' => 'Password must be minimum 6 character alphanumeric.',
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter valid email Address.',
                'email.unique' => 'Email is already register',
                'country_id.required' => 'Please select country.',
                'country_id.integer' => 'Country must be an integer',
                'country_id.exists' => 'Country is not exists',
                'newsletter.required' => 'Newsletter is required',
                'newsletter.in' => 'Newsletter type not valid (Yes,No)',
                'date_of_birth.required' => 'Date Of Birth is required',
                'date_of_birth.date' => 'Date Of Birth is not valid',
                'date_of_birth.before' => 'Date Of Birth is smaller then today',
            ],
        ],
    ],
    'login' => [
        'v1' => [
            'rules' => [
                'email' => 'required',
                'password' => 'required',
            ],
            'messages' => [
                'email.required' => 'api/login.email_is_required',
                'password.required' => 'api/login.password_is_required',
            ],
        ],
    ],
    'forgot_password' => [
        'v1' => [
            'rules' => [
                'email' => [
                    'required',
                    'email',
                    \Illuminate\Validation\Rule::exists('users')->where(function ($query) {
                        $query->where('status_id', \App\Status::$ACTIVE);
                    })
                ],
            ],
            'messages' => [
                'email.required' => 'api/login.email_is_required',
                'email.email' => 'api/login.email_is_not_valid',
                'email.exists' => 'api/login.email_does_not_exists',
            ],
        ],
    ],
    'reset_password' => [
        'v1' => [
            'rules' => [
                'reset_pass_token' => 'required',
                'password' => 'required|min:6',
            ],
            'messages' => [
                'reset_pass_token.required' => 'api/login.reset_pass_token_is_required',
                'password.required' => 'api/login.password_is_required',
                'password.min' => 'api/login.password_min',
            ],
        ],
    ],
    'change_password' => [
        'v1' => [
            'rules' => [
                'old_password' => 'required',
                'password' => 'required|min:6',
            ],
            'messages' => [
                'old_password.required' => 'api/login.old_password_is_required',
                'password.required' => 'api/login.password_is_required',
                'password.min' => 'api/login.password_min',
            ],
        ],
    ],
    'select_character' => [
        'v1' => [
            'rules' => [
                'character_id' => 'required|exists:character,id',
                'select_character' => 'required|in:own,want',
            ],
            'messages' => [
                'character_id.required' => 'character id is required',
                'character_id.exists' => 'character id is not required',
                'select_character.required' => 'select character is required',
                'select_character.in' => 'select character is not valid',
            ],
        ],
    ],
    'change_profile' => [
        'v1' => [
            'rules' => [
                'username' => 'required',
                'country_id' => 'required|integer|exists:country,id',
                'newsletter' => 'required|in:Yes,No',
                'date_of_birth' => 'required|date|before:today',
            ],
            'messages' => [
                'username.required' => 'api/login.name_is_required',
                'country_id.required' => 'Country is required',
                'country_id.integer' => 'Country must be an integer',
                'country_id.exists' => 'Country is not exists',
                'newsletter.required' => 'api/login.newsletter_is_required',
                'newsletter.in' => 'Newsletter type not valid (Yes,No)',
                'date_of_birth.required' => 'Date Of Birth is required',
                'date_of_birth.date' => 'Date Of Birth is not valid',
                'date_of_birth.before' => 'Date Of Birth is smaller then today',
            ],
        ],
    ],
];