<?php

// ==================================
//        File-Specific Styling
// ==================================
// By Adding a $page_styles array at
// the start of your view page. You 
// can add specific CSS files to be
// loaded in the view page.
//
// Make sure to incldue the whole
// file path inside the public folder.
// (e.g '/styles/index.css')
//
//  Also, make sure that PAGE STYLES
//  PRECEED THE INITIALIZATION OF
//  HEAD.PHP FILE
//

$page_styles = [
    '/css/index.css',
];

// ===========================================
//             View File Structure
// ===========================================
// ALWAYS ADD THE require 'partials/head.php'
// at the top of the file and the require
// 'partials/footer.php' at the end of the
// file.
//
// You can also add other partial or UI
// components by adding its full path string
// on the base_path() function as done below.
//  

require base_path('views/partials/head.php')

?>
<?php require base_path('views/components/text-input.php') ?>

<!-- Your HTML code goes here -->

<?php

// Get the current URI's ID
$uri = $_SERVER['REQUEST_URI'];
$segments = explode('/', $uri);
$id = end($segments);

?>

<main class="main">
    <div>
        <form action="/forgot-password" method="POST">
            <input name="_method" value="PATCH" hidden />
            <input name="id_to_update" value="<?php echo $id; ?>" hidden />
            <span class="w-full mt-4 mb-2">
                <?php text_input('Password', 'password', 'password', '', 'password') ?>
                <?php text_input('Confirm Password', 'confirm_password', 'confirm password', '', 'password') ?>
            </span>

            <button class="btn-signin" name="set_new_pass">Set New Password</button>
        </form>
        <section>
            <i class="bi bi-key-fill"></i>
            <h2>Set New Password</h2>
        </section>
    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>