<!--======================================
            This is a 404 Page 
    ======================================

    This page is displayed by the router.
    If it encounters an error.
-->

<?php $page_styles = ['/css/banner.css'];
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/sidebar.php') ?>

<main class="w-full h-dvh flex flex-col">
    <?php require base_path('views/partials/banner.php') ?>
    <div class="m-16 grow flex items-center justify-center flex-col gap-2">
        <h1 class="text-2xl font-bold">Sorry but the resource you want is not Found.</h1>
        <a href="/" class="text-blue-700 hover:underline">Return to Home</a>
    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>