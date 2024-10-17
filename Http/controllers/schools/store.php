<?php

//  ==========================================
//           This is the Controller 
// ===========================================
// 
//  This is where you load the corresponding
//  view file for this route if available
// 
//   Use the view() function and feed the 
//   full path of the view.
// 
//   Being the controller file. This is where 
//   the data is get, manipulated, and/or
//   saved.
//      
//   You can pass variables to your view as the
//   second parameter of the view function.
//      
//   view('notes/{id}', ['notes' => $notes])
//
//   view variables are passed as keu-value
//   pairs as illustrated in the example above.
//

use Core\Database;
use Core\App;
use Http\Forms\SchoolAddForm;

$db = App::resolve(Database::class);

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

$db->query('INSERT INTO schools( 
    school_id,
    school_name,
    type_id,
    division_id,
    district_id
    )
    VALUES(:school_id,
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

$db->query('INSERT INTO school_contacts( 
    contact_name,
    school_id,
    contact_no,
    contact_email
    )
    VALUES(:contact_name,
    :school_id,
    :contact_no,
    :contact_email
)', [
     'contact_name' => $_POST['contact_name'],
     'school_id' => $_POST['school_id'],
     'contact_no' => $_POST['contact_no'],
     'contact_email' => $_POST['contact_email']
]);

$messageSchoolID = $_POST['school_id'];
$messageSchoolName = $_POST['school_name'];

toast('Sucessfully Added School: ' . $messageSchoolName . ' with School ID: ' . $messageSchoolID);

redirect('/coordinator/schools');