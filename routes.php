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

$router->get('/coordinator/schools', 'schools/index.php')->only('coordinator');

$router->get('/coordinator/users', 'users/index.php')->only('coordinator');
$router->get('/coordinator/users/pending', 'users/pending/index.php')->only('coordinator');


$router->get('/403', 'http_errors/403.php');
$router->get('/404', 'http_errors/404.php');
$router->get('/500', 'http_errors/500.php');
