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

    // crud.releases.inputs.status
// crud.release_issues.new_title

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
            'status' => 'Status',
            'released_at' => 'Released At',
        ],
    ],

    'issues' => [
        'name' => 'Issues',
        'index_title' => 'Issues List',
        'new_title' => 'New Issue',
        'create_title' => 'Create Issue',
        'edit_title' => 'Edit Issue',
        'show_title' => 'Show Issue',
        'inputs' => [
            'key'     => 'Key',
            'summary' => 'Summary',
            'url'     => 'Url',
        ],
    ],
    'issue_releases' => [
        'name' => 'Release Issues',
        'index_title' => ' List',
        'new_title' => 'New Release Issue',
        'create_title' => 'Create release_issue',
        'edit_title' => 'Edit release_issue',
        'show_title' => 'Show release_issue',
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
