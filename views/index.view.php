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

<main class="main">
    <div>
        <form action="/" method="POST">

            <i class="bi bi-person-circle person"></i>
            <h4 class="font-black signin">Sign In</h4>

            <span class="w-full mb-2">
                <?php text_input('Username', 'user_name', 'your username', old('user_name')) ?>
                <?php if (isset($errors['email'])): ?>
                    <p class="error"><?= $errors['user_name'] ?></p>
                <?php endif; ?>
            </span>
            <span class="w-full">
                <?php text_input('Password', 'password', 'your password', '', 'password') ?>
                <?php if (isset($errors['password'])): ?>
                    <p class="error"><?= $errors['password'] ?></p>
                <?php endif; ?>
            </span>

            <a href="/forgot-password" class="forgot-password">Forgot your password?</a>

            <button class="btn-signin">Log In</button>
        </form>
        <section>
            <img src="/sdo.png" class="sidebar-icon2" style="width: 170px; height: auto; clip-path: circle(50%); margin-top: -3rem; margin-bottom: 1rem; " />
            <h2>ICT - Resource</h2>
            <h2>Inventory System</h2>
        </section>
    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>