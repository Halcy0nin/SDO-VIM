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
        <?php require base_path('views/partials/coordinator/schools/add_school_modal.php') ?>
        <?php require base_path('views/partials/coordinator/schools/import_school_modal.php') ?>
        <?php require base_path('views/partials/coordinator/schools/export_school_modal.php') ?>
    </section>
    <section class="mx-12 flex flex-col">
        <form class="search-container search" method="POST" action="/coordinator/schools/s">
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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Division</th>
                    <th>District</th>
                    <th>Contact Name</th>
                    <th>Contact Number</th>
                    <th>Contact Email</th>
                    <th>Date Added</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php if (count($schools) > 0): ?>
                        <?php foreach ($schools as $school): ?>
                            <tr>
                                <td><?= htmlspecialchars($school['school_id']) ?></td>
                                <td><?= htmlspecialchars($school['school_name']) ?></td>
                                <td style="text-transform: capitalize;"><?= htmlspecialchars($school['type']) ?></td>
                                <td><?= htmlspecialchars($school['division']) ?></td>
                                <td><?= htmlspecialchars($school['district']) ?></td>
                                <td><?= htmlspecialchars($school['contact_name']) ?></td>
                                <td><?= htmlspecialchars($school['contact_no']) ?></td>
                                <td><?= htmlspecialchars($school['contact_email']) ?></td>
                                <td><?= htmlspecialchars(formatTimestamp($school['date_added'])) ?></td>
                                <td>
                                    <div class="h-full w-full flex items-center gap-2">
                                        <button class="inventory-btn">
                                            <a href="/coordinator/school-inventory/<?= $school['school_id'] ?>">
                                                <i class="bi bi-box-seam-fill"></i>
                                            </a>
                                        </button>
                                        <?php require base_path('views/partials/coordinator/schools/view_receipt_modal.php') ?>
                                        <?php require base_path('views/partials/coordinator/schools/edit_school_modal.php') ?>
                                        <?php require base_path('views/partials/coordinator/schools/delete_school_modal.php') ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">
                                <div class="h-full w-full flex items-center gap-2">
                                    No Schools Found
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
                                        action="/coordinator/schools/s?page=1">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-bar-left"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/schools/s?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-left"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/schools/s?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-right"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/schools/s?page=<?= htmlspecialchars($pagination['pages_total']) ?>">
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