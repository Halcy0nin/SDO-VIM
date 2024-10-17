<?php
use Core\Database;
use Core\App;
use Http\Forms\SchoolAddForm;

$db = App::resolve(Database::class);

try {
    // Validate the form inputs
    $form = SchoolAddForm::validate($attributes = [
        'school_id' => $_POST['school_id'],
        'school_name' => $_POST['school_name'],
        'school_type' => $_POST['school_type'],
        'school_division' => $_POST['school_division'],
        'school_district' => $_POST['school_district'],
        'contact_name' => $_POST['contact_name'],
        'contact_no' => $_POST['contact_no'],
        'contact_email' => $_POST['contact_email'],
    ]);

    // Insert the school details into 'schools' table
    $db->query('INSERT INTO schools( 
        school_id,
        school_name,
        type_id,
        division_id,
        district_id
    ) VALUES (
        :school_id,
        :school_name,
        :school_type,
        :school_division,
        :school_district
    )', [
        'school_id' => $_POST['school_id'],
        'school_name' => $_POST['school_name'],
        'school_type' => $_POST['school_type'],
        'school_division'=> $_POST['school_division'],
        'school_district' => $_POST['school_district']
    ]);

    // Insert the contact details into 'school_contacts' table
    $db->query('INSERT INTO school_contacts( 
        contact_name,
        school_id,
        contact_no,
        contact_email
    ) VALUES (
        :contact_name,
        :school_id,
        :contact_no,
        :contact_email
    )', [
        'contact_name' => $_POST['contact_name'],
        'school_id' => $_POST['school_id'],
        'contact_no' => $_POST['contact_no'],
        'contact_email' => $_POST['contact_email']
    ]);

    // Prepare the success message
    $messageSchoolID = $_POST['school_id'];
    $messageSchoolName = $_POST['school_name'];

    // Show success toast message
    toast('Successfully Added School: ' . $messageSchoolName . ' with School ID: ' . $messageSchoolID);

    // Redirect to the schools list page
    redirect('/coordinator/schools');

} catch (PDOException $e) {
    // Handle any database errors
    error_log($e->getMessage());  // Log the error for debugging

    // Show an error toast message
    toast('Failed to add the school. Please try again.');

    // Redirect back to the form or another appropriate page
    redirect('/coordinator/schools');
}
