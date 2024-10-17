<?php

use Core\Database;
use Core\App;
use Http\Forms\SchoolEditForm;

$db = App::resolve(Database::class);

try {
    $form = SchoolEditForm::validate($attributes = [
        '_school_id' => $_POST['id_to_update'],
        'school_id' => $_POST['school_id'],
        'school_name' => $_POST['school_name'],
        'school_type' => $_POST['school_type'],
        'school_division' => $_POST['school_division'],
        'school_district' => $_POST['school_district'],
        'contact_name' => $_POST['contact_name'],
        'contact_no' => trim($_POST['contact_no']),
        'contact_email' => $_POST['contact_email'],
    ]);

    // Update the school ID first (if needed)
    $db->query('UPDATE schools
        SET school_id = :new_school_id
        WHERE school_id = :current_school_id', [
        'new_school_id' => $_POST['school_id'],
        'current_school_id' => $_POST['id_to_update']
    ]);

    // Update the school details
    $db->query(
        'UPDATE schools 
        SET 
            school_name = :school_name,
            type_id = :school_type,
            division_id = :school_division,
            district_id = :school_district
        WHERE school_id = :id_to_update', [
            'school_name' => $_POST['school_name'],
            'school_type' => $_POST['school_type'],
            'school_division' => $_POST['school_division'],
            'school_district' => $_POST['school_district'],
            'id_to_update' => $_POST['id_to_update']
        ]
    );

    // Update the school contacts
    $db->query('UPDATE school_contacts
        SET
            contact_name = :contact_name,
            contact_no = :contact_no,
            contact_email = :contact_email
        WHERE school_id = :school_id', [
            'contact_name' => $_POST['contact_name'],
            'contact_no' => $_POST['contact_no'],
            'contact_email' => $_POST['contact_email'],
            'school_id' => $_POST['school_id']
        ]);

    // Prepare success message
    $messageSchoolName = $_POST['school_name'];
    $messageSchoolID = $_POST['school_id'];
    toast('Successfully Updated School: ' . $messageSchoolName . ' with School ID: ' . $messageSchoolID);

    // Redirect to the schools list
    redirect('/coordinator/schools');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to update the school. Please try again.');

    // Redirect back to the schools list
    redirect('/coordinator/schools');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the schools list
    redirect('/coordinator/schools');
}
