<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
    if (isset($_POST['approve_assigned_item'])) { // Check if 'approve_assigned_item' button was pressed
        // Get the selected items from the POST request
        $selectedItems = $_POST['selected_items'] ?? [];
        $school_id = $_POST['school_id'] ?? null;
        $item_code = $_POST['item_code'] ?? null;

        // Check if there are selected items to process
        if (!empty($selectedItems)) {
            foreach ($selectedItems as $item_code) {
                $new_item_code = $school_id . '-' . $item_code;

                // Update the school inventory for each selected item
                $db->query('UPDATE school_inventory 
                            SET school_id = :school_id, 
                                item_code = :new_item_code,
                                item_assigned_status = 1, 
                                updated_by = :updated_by
                            WHERE item_code = :id;', [
                    'id' => $item_code,
                    'new_item_code' => $new_item_code,
                    'school_id' => $school_id,
                    'updated_by' => $_SESSION['user']['user_id'] ?? 'Admin'
                ]);
            }

            // Show a success message for multiple items
            toast('Successfully assigned items to the school.');
        } elseif ($item_code) { // If no selected items but a single item_code is present
            $new_item_code = $school_id . '-' . $item_code;

            // Update the school inventory for the single item
            $db->query('UPDATE school_inventory 
                        SET school_id = :school_id, 
                            item_code = :new_item_code,
                            item_assigned_status = 1, 
                            updated_by = :updated_by
                        WHERE item_code = :id;', [
                'id' => $item_code,
                'new_item_code' => $new_item_code,
                'school_id' => $school_id,
                'updated_by' => $_SESSION['user']['user_id'] ?? 'Admin'
            ]);

            // Show a success message for a single item
            toast('Successfully assigned item: ' . $new_item_code);
        } else {
            // Show a message if no items were selected and no item_code was provided
            toast('No items were selected for assignment.');
        }
    } else { // If the 'approve_assigned_item' button was NOT pressed
        $item_code = $_POST['item_code'] ?? null;

        // Update the item_assigned_status to 0 and item_assigned_school to NULL
        if (!empty($selectedItems)) {
            foreach ($selectedItems as $item_code) {
                $db->query('UPDATE school_inventory 
                            SET item_assigned_status = 0, 
                                item_assigned_school = NULL
                            WHERE item_code = :id;', [
                    'id' => $item_code
                ]);
            }

            toast('Successfully unassigned selected items.');
        } elseif ($item_code) {
            $db->query('UPDATE school_inventory 
                        SET item_assigned_status = 0, 
                            item_assigned_school = NULL
                        WHERE item_code = :id;', [
                'id' => $item_code
            ]);

            toast('Successfully unassigned item: ' . $item_code);
        } else {
            toast('No items were selected for unassignment.');
        }
    }

    // Redirect to the specified resources page
    redirect('/coordinator/resources/assigned');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to process the item(s). Please try again.');

    // Redirect back to the resources page
    redirect('/coordinator/resources/assigned');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the resources page
    redirect('/coordinator/resources/assigned');
}
