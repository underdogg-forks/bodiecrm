<?php
    /**
     * Default lead fields
     */
    return [
        'fields'    => [
            '_token',               // Prevent CSRF token from being stored as custom field
            '_redirect',            // Boolean redirect flag

            'landing_page_id',
            'auth_key',
            'first_name',
            'last_name',
            'email',
            'company',
            'title',
            'phone',
            'address',
            'city',
            'state',
            'zip',
            'country'
        ]
    ];
?>