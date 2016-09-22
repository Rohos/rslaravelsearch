<?php

return [
    // GENERAL
    'mtd_prefix' => '_', // Prefix search methods
    'default_limit' => 20, // Default limit
    'default_page_name' => 'page', // Default page name
    'default_order' => 'id', // Default order
    'default_order_dir' => 'asc', // Default order dir
    // COUNT WITH COUNT
    'all_count_key' => 'count', // The key to the total number of
    'current_count_key' => 'current_count', // The key to the current number of
    'items_key' => 'items', // The key to a list of records
    'default_get_fields' => ['*'], // The fields for get query
    'default_count_fields' => '*', // The fields for count query
    // DATATABLES
    'datatable_all_count_key' => '*', // The key to the total number of for datatables
    'datatable_current_count_key' => '*', // The key to the current number of for datatables
    'datatable_items_key' => '*', // The key to a list of records for datatables
];