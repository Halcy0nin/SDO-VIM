<?php $page_styles = ['/css/banner.css'];
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/sidebar.php') ?>
<?php require base_path('views/components/text-input.php') ?>
<?php require base_path('views/components/select-input.php') ?>
<?php require base_path('views/components/radio-group.php') ?>


<!-- Your HTML code goes here -->

<main class="main-col">
    <section class="flex items-center pr-12 gap-3">
        <?php require base_path('views/partials/banner.php') ?>
    </section>
    <section class="mx-12 mb-12 h-dvh rounded flex flex-col">
        <?php require base_path('views/partials/coordinator/users/tabs.php') ?>
        <div class="grow mt-4 bg-zinc-50 rounded border-[1px] overflow-hidden">
            <?php require base_path('views/partials/coordinator/users/requests_table.php') ?>
        </div>
    </section>

</main>
<?php require base_path('views/partials/footer.php') ?>