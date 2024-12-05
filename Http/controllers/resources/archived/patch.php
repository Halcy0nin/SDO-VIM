<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
        // Get the selected items from the POST archive
        $selectedItems = $_POST['selected_items'] ?? [];
        $item_code = $_POST['item_code'] ?? null; // For updating a single item
    
        // Check if there are selected items to process
        if (!empty($selectedItems)) {
            foreach ($selectedItems as $item_code) {
                // Update the item_request_status for each selected item
                $db->query('UPDATE school_inventory 
                            SET is_archived = 0
                            WHERE item_code = :id;', [
                    'id' => $item_code,
                ]);
            }
    
            // Show a success message for multiple items
            toast('Successfully unarchived selected items.');
        } elseif ($item_code) { // If no selected items but a single item_code is present
            // Update the item_archive_status for the single item
            $db->query('UPDATE school_inventory 
                        SET is_archived = 0
                        WHERE item_code = :id;', [
                'id' => $item_code,
            ]);
    
            // Show a success message for a single item
            toast('Successfully unarchived item: ' . $item_code);
        } else {
            // Show a message if no items were selected and no item_code was provided
            toast('No items were selected for update and no item code was provided.');
        }

    // Redirect to the specified resources page
    redirect('/coordinator/resources/archived');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to process the item(s). Please try again.');

    // Redirect back to the resources page
    redirect('/coordinator/resources/archived');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the resources page
    redirect('/coordinator/resources/archived');
}
