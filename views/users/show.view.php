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
        <?php require base_path('views/partials/coordinator/users/add_user_modal.php') ?>
        <?php require base_path('views/partials/coordinator/users/import_user_modal.php') ?>
        <?php require base_path('views/partials/coordinator/users/export_user_modal.php') ?>
    </section>
    <section class="mx-12 flex flex-col">
        <?php require base_path('views/partials/coordinator/users/tabs.php') ?>
        <form class="search-container search" method="POST" action="/coordinator/users/s">
            <input type="text" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
            <button type="submit" class="search">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </section>
    <section class="mx-12 mb-12 inline-block grow rounded">
        <div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
            <table class="table table-striped m-0">
                <thead>
                    <th class="w-[5ch]">ID</th>
                    <th>Username</th>
                    <th class="w-[12ch]">Role</th>
                    <th>School</th>
                    <th>Contact Name</th>
                    <th class="w-[16ch]">Mobile Number</th>
                    <th class="w-[24ch]">Email</th>
                    <th class="w-[12ch]">Date Added</th>
                    <th class="w-[12ch]">Date Modified</th>
                    <th class="w-[16ch]">Actions</th>
                </thead>
                <tbody>
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['user_id']) ?></td>
                                <td><?= htmlspecialchars($user['user_name']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td><?= htmlspecialchars($user['school'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['contact_name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['contact_no'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['contact_email'] ?? '') ?></td>
                                <td><?= htmlspecialchars(formatTimestamp($user['date_added'])) ?></td>
                                <td><?= htmlspecialchars(formatTimestamp($user['date_modified'])) ?></td>
                                <td>
                                    <div class="h-full w-full flex items-center gap-2">
                                        <?php require base_path('views/partials/coordinator/users/password_change_modal.php') ?>
                                        <?php require base_path('views/partials/coordinator/users/edit_user_modal.php') ?>
                                        <?php require base_path('views/partials/coordinator/users/delete_user_modal.php') ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">
                                <div class="h-full w-full flex items-center gap-2">
                                    No Users Found
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="overflow-hidden">
                    <tr>
                        <td colspan="10" class="py-2 pr-4">
                            <div class="w-full flex items-center justify-end gap-2">
                                <p class="grow text-end mr-2">Page - <?= htmlspecialchars($pagination['pages_current']) ?> / <?= htmlspecialchars($pagination['pages_total']) ?></p>
                                <?php if ($pagination['pages_total'] > 1): ?>
                                    <form
                                        method="POST"
                                        action="/coordinator/users/s?page=1">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-bar-left"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/users/s?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-left"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/users/s?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-right"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/users/s?page=<?= htmlspecialchars($pagination['pages_total']) ?>">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-bar-right"></i></button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

</main>
<?php require base_path('views/partials/footer.php') ?>