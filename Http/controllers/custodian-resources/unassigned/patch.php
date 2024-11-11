<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
    // Get the selected items from the POST request
    $selectedItems = $_POST['selected_items'] ?? [];
    $school_id = $_POST['school_id'] ?? null; // Assuming you have a school_id input in your form
    $item_code = $_POST['item_code'] ?? null; // Assuming you are still sending a single item_code for the original update

    // Check if there are selected items to process
    if (!empty($selectedItems)) {
        foreach ($selectedItems as $item_code) {
            $new_item_code = $school_id . '-' . $item_code;

            // Update the school inventory for each selected item
            $db->query('UPDATE school_inventory 
                        SET school_id = :school_id, 
                            item_code = :new_item_code,
                            updated_by = :updated_by
                        WHERE item_code = :id;', [
                'id' => $item_code,
                'new_item_code' => $new_item_code,
                'school_id' => $school_id,
                'updated_by' => $_SESSION['user']['user_id'] ?? 'Admin'
            ]);
        }

        // Show a success message for multiple items
        toast('Successfully updated item codes for selected items.');

    } elseif ($item_code) { // If no selected items but a single item_code is present
        $new_item_code = $school_id . '-' . $item_code;

        // Update the school inventory for the single item
        $db->query('UPDATE school_inventory 
                    SET school_id = :school_id, 
                        item_code = :new_item_code,
                        updated_by = :updated_by
                    WHERE item_code = :id;', [
            'id' => $item_code,
            'new_item_code' => $new_item_code,
            'school_id' => $school_id,
            'updated_by' => $_SESSION['user']['user_id'] ?? 'Admin'
        ]);

        // Show a success message for a single item
        toast('Successfully updated item code: ' . $new_item_code);

    } else {
        // Show a message if no items were selected and no item_code was provided
        toast('No items were selected for update and no item code was provided.');
    }

    // Redirect to the specified resources page
   redirect('/custodian/custodian-resources/unassigned');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to assign the item. Please try again.');

    // Redirect back to the resources page
   redirect('/custodian/custodian-resources/unassigned');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the resources page
   redirect('/custodian/custodian-resources/unassigned');
}