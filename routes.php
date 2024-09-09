<?php

// =========================================================
//          This is the list of your VALID ROUTES
// =========================================================
//  List your uri routes here with their corresponding HTTP 
//  methods listed in the Router File.
// 
// 
//  You can use get, post, patch, put, and destroy methods 
//  here. However, you need to manually append a hidden 
//  input on your form to explicitly use PATCH, PUT, and
//  DESTROY methods. You can do this by adding a text input 
//  with name="_method" and value of either of the explicitly
//  set methods; value="DESTROY".
// 
//  You can use slugs by enclosing the id using brackets {}. 
//
//     get('notes/{id}', 'notes/show.php')->only('auth')
// 
//  The given example above uses a slug and also a middleware 
//  for auth class.
//
// 
//  tldr; First specify the HTTP method then provide the
//  uri path as the first parameter, then the controller
//  for the path as the second paramter. Lastly, append
//  the only function and provide the middleware class
//  to be used in the route.
// 

$router->get('/', 'index.php')->only('guest');
$router->post('/', 'session/store.php')->only('guest');
$router->delete('/', 'session/destroy.php')->only('auth');

$router->get('/coordinator', 'coordinator/create.php')->only('coordinator');

$router->get('/coordinator/resources', 'resources/index.php')->only('coordinator');
$router->post('/coordinator/resources/s', 'resources/show.php')->only('coordinator');
$router->get('/coordinator/resources/unassigned', 'resources/unassigned/index.php')->only('coordinator');
$router->post('/coordinator/resources/unassigned/s', 'resources/unassigned/show.php')->only('coordinator');
$router->get('/coordinator/resources/working', 'resources/working/index.php')->only('coordinator');
$router->post('/coordinator/resources/working/s', 'resources/working/show.php')->only('coordinator');
$router->get('/coordinator/resources/repair', 'resources/repair/index.php')->only('coordinator');
$router->post('/coordinator/resources/repair/s', 'resources/repair/show.php')->only('coordinator');
$router->get('/coordinator/resources/condemned', 'resources/condemned/index.php')->only('coordinator');
$router->post('/coordinator/resources/condemned/s', 'resources/condemned/show.php')->only('coordinator');

//Assign resource to school
$router->patch('/coordinator/resources/unassigned', '/resources/unassigned/patch.php')->only('coordinator');
//Add resource
$router->post('/coordinator/resources', 'resources/store.php')->only('coordinator');
//Import Resource
$router->post('/coordinator/resources/importcsv', '/resources/import/store.php')->only('coordinator');

$router->get('/coordinator/schools', 'schools/index.php')->only('coordinator');
$router->post('/coordinator/schools/s', 'schools/show.php')->only('coordinator');
//Create School
$router->post('/coordinator/schools', '/schools/store.php')->only('coordinator');
//Edit School Details
$router->patch('/coordinator/schools', '/schools/patch.php')->only('coordinator');
//Delete School
$router->delete('/coordinator/schools', '/schools/destroy.php')->only('coordinator');
//Export School Data to CSV
$router->post('/coordinator/schools/exportcsv', '/schools/export_school_csv.php')->only('coordinator');


//Import School
$router->post('/coordinator/schools/importcsv', '/schools/import/store.php')->only('coordinator'); //upload

//Export School Data to PDF
$router->post('/coordinator/schools/exportpdf', '/schools/export_school_pdf.php')->only('coordinator');


$router->get('/coordinator/school-inventory/{id}', 'school-inventory/index.php')->only('coordinator');
$router->post('/coordinator/school-inventory/{id}/s', 'school-inventory/show.php')->only('coordinator');
//Create Item
$router->post('/coordinator/school-inventory', '/school-inventory/store.php')->only('coordinator');
//Edit Item
$router->patch('/coordinator/school-inventory', '/school-inventory/patch.php')->only('coordinator');
//Delete Item
$router->delete('/coordinator/school-inventory', '/school-inventory/destroy.php')->only('coordinator');


//Export School Data to XLS
$router->post('/coordinator/schools/exportxls', '/schools/export_school_xls.php')->only('coordinator');

$router->get('/coordinator/users', 'users/index.php')->only('coordinator');
//Create User
$router->post('/coordinator/users', 'users/store.php')->only('coordinator');
//Edit User Details
$router->patch('/coordinator/users', 'users/patch.php')->only('coordinator');
//Delete School
$router->delete('/coordinator/users', 'users/destroy.php')->only('coordinator');
//Change User Password
$router->patch('/coordinator/users/changePassword', '/users/changePassword.php')->only('coordinator');
//Export User Data to CSV
$router->post('/coordinator/users/exportcsv', '/users/export_user_csv.php')->only('coordinator');
//Import User
$router->post('/coordinator/users/importcsv', '/users/import/store.php')->only('coordinator'); //upload

$router->get('/coordinator/users/pending', 'users/pending/index.php')->only('coordinator');
$router->get('/coordinator/users/approved', 'users/approved/index.php')->only('coordinator');
$router->get('/coordinator/users/denied', 'users/denied/index.php')->only('coordinator');

// Custodian Routes
$router->get('/custodian', 'custodian/create.php')->only('custodian');

$router->post('/custodian/receipt', 'custodian/receipt/store.php')->only('custodian');

$router->get('/custodian/custodian-inventory', 'custodian-inventory/index.php')->only('custodian');
//Create Item
$router->post('/custodian/custodian-inventory', '/custodian-inventory/store.php')->only('custodian');
//Edit Item
$router->patch('/custodian/custodian-inventory', '/custodian-inventory/patch.php')->only('custodian');
//Delete Item
$router->delete('/custodian/custodian-inventory', '/custodian-inventory/destroy.php')->only('custodian');

$router->get('/custodian/custodian-resources', 'custodian-resources/index.php')->only('custodian');
$router->get('/custodian/custodian-resources/unassigned', 'custodian-resources/unassigned/index.php')->only('custodian');
$router->get('/custodian/custodian-resources/working', 'custodian-resources/working/index.php')->only('custodian');
$router->get('/custodian/custodian-resources/repair', 'custodian-resources/repair/index.php')->only('custodian');
$router->get('/custodian/custodian-resources/condemned', 'custodian-resources/condemned/index.php')->only('custodian');

//Assign Item to School
$router->patch('/custodian/custodian-resources/unassigned', '/custodian-resources/unassigned/patch.php')->only('custodian');

$router->get('/403', 'http_errors/403.php');
$router->get('/404', 'http_errors/404.php');
$router->get('/500', 'http_errors/500.php');
