<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
   
    $db->query('UPDATE add_item_requests 
        SET item_request_status = 3
        WHERE id = :id;', [
        'id' => $_POST['request_to_update'],
        ]);
      // Show a success message
      toast('Successfully cancelled request to add item with code: ' . $item_code);

    // Redirect to the specified resources page
    redirect('/custodian/custodian-resources/requests');
    
} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to update the request status. Please try again.');

    // Redirect back to the resources page
    redirect('/custodian/custodian-resources/requests');
} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the resources page
    redirect('/custodian/custodian-resources/requests');
}
