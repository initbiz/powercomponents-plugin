<?php return [
    'plugin' => [
        'name' => 'PowerComponents',
        'description' => 'Plugin with set of traits and behaviors for components that moves working with components to a next level'
    ],
    'list_component_properties' => [
        'record_page' => 'Click record page',
        'record_page_desc' => 'Choose page to redirect after clicking row',
        'create_page' => 'Page to create record',
        'create_page_desc' => 'Choose page with create record component',
    ],
    'list_toolbar' => [
        'add_item' => 'Add item',
        'filter_placeholder' => 'Type to filter'
    ],
    'list_actions' => [
        'title' => 'Actions',
        'delete_confirmation' => 'Do you really want to delete the record?',
    ],
    'component_properties' => [
        'pages_group' => 'Pages',
        'list_page' => 'List page',
        'list_page_desc' => 'Page of records list',
        'update_page' => 'Update page',
        'update_page_desc' => 'Page to update record',
        'create_page' => 'Create page',
        'create_page_desc' => 'Page to create record',
        'preview_page' => 'Preview page',
        'preview_page_desc' => 'Page to preview record',
    ],
    'form_component_properties' => [
        'context' => 'Context',
        'context_desc' => 'Context of component: create, update or preview',
        'context_create' => 'Create',
        'context_update' => 'Update',
        'context_preview' => 'Preview',
        'record_key' => 'Record ID',
        'record_key_desc' => 'ID probably from URL to bind to page',
        'record_key_name' => 'Primary key column',
        'record_key_name_desc' => 'Column name with primary key',
    ],
    'form_actions' => [
        'create' => 'Create',
        'create_and_next' => 'Create and next',
        'create_and_close' => 'Create and close',
        'cancel' => 'Cancel',
        'saving' => 'Saving',
        'or' => 'or',
        'update' => 'Save',
        'update_and_close' => 'Save and close',
        'back_to_list' => 'Back to list',
        'update_record' => 'Update record',
        'delete' => 'Delete',
        'delete_confirm' => 'Are you sure?',
        'delete_success' => 'Record deleted successfully',
    ],
    'form_save' => [
        'success' => 'Successfully saved'
    ],
    'permissions' => [
        'access_forbidden' => 'Access to data is forbidden'
    ],
    'exception' => [
        'not_defined' => '":name" not defined or bad class'
    ],
    'misc' => [
        'loader_text' => 'Loading...'
    ],
];
