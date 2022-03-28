<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'projects' => [
        'name' => 'Projects',
        'index_title' => 'Projects List',
        'new_title' => 'New Project',
        'create_title' => 'Create Project',
        'edit_title' => 'Edit Project',
        'show_title' => 'Show Project',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'releases' => [
        'name' => 'Releases',
        'index_title' => 'Releases List',
        'new_title' => 'New Release',
        'create_title' => 'Create Release',
        'edit_title' => 'Edit Release',
        'show_title' => 'Show Release',
        'inputs' => [
            'name' => 'Name',
            'project_id' => 'Project',
            'document' => 'Document',
            'released_at' => 'Released At',
        ],
    ],

    'tickets' => [
        'name' => 'Tickets',
        'index_title' => 'Tickets List',
        'new_title' => 'New Ticket',
        'create_title' => 'Create Ticket',
        'edit_title' => 'Edit Ticket',
        'show_title' => 'Show Ticket',
        'inputs' => [
            'key'     => 'Key',
            'summary' => 'Summary',
            'url'     => 'Url',
        ],
    ],

    'ticket_releases' => [
        'name' => 'Ticket Releases',
        'index_title' => ' List',
        'new_title' => 'New Release ticket',
        'create_title' => 'Create release_ticket',
        'edit_title' => 'Edit release_ticket',
        'show_title' => 'Show release_ticket',
        'inputs' => [
            'release_id' => 'Release',
        ],
    ],

    'templates' => [
        'name' => 'Templates',
        'index_title' => 'Templates List',
        'new_title' => 'New Template',
        'create_title' => 'Create Template',
        'edit_title' => 'Edit Template',
        'show_title' => 'Show Template',
        'inputs' => [
            'name' => 'Name',
            'document' => 'Document',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
