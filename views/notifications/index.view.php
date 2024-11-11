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
    <section class="mx-12 mb-12 inline-block grow rounded">
        <div class="notifications-container">
            <?php if (count($notifications) <= 0): ?>
                <div class="notification-card rounded border-[1px] border-zinc-100 bg-zinc-50 p-2">
                    <h5 class="font-bold text-xl text-[#434F72] text-center">You Have No Notifications</h5>
                </div>
            <?php else: ?>
                <?php foreach ($notifications as $notification): ?>
                    <div class="notification-card rounded border-[1px] border-zinc-100 bg-zinc-50 p-2">
                        <h5 class="font-bold text-xl text-[#434F72]"><?= $notification['title'] ?></h5>
                        <p class="ml-1 opacity-95"><?= $notification['message'] ?></p>
                        <small style="color: rgb(161 161 170); font-style: italic; font-size: 0.875rem; line-height: 1.25rem;"><?= formatTimestamp($notification['date_added'], 'M d, Y') ?></small>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </section>
</main>
<?php require base_path('views/partials/footer.php') ?>