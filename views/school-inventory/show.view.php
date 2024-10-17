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
        <?php require base_path('views/partials/coordinator/school-inventory/add_item_modal.php') ?>
        <?php require base_path('views/partials/coordinator/schools/export_school_modal.php') ?>
    </section>
    <section class="mx-12 flex flex-col">
        <form class="search-container search" method="POST" action="/coordinator/school-inventory/<?= $id ?>/s">
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
                    <th style="width: 20ch;">Item Code</th>
                    <th style="width: 10ch;">Article</th>
                    <th style="width: 10ch;">Description</th>
                    <th style="width: 12ch;">Date Acquired</th>
                    <th style="width: 11ch;">Status</th>
                    <th>Source of Funds</th>
                    <th>Unit Value</th>
                    <th>Qty.</th>
                    <th>Total Value</th>
                    <th>Active</th>
                    <th>Inactive</th>
                    <th>Last Updated</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php if (count($items) > 0): ?>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['item_code']) ?></td>
                                <td><?= htmlspecialchars($item['item_article']) ?></td>
                                <td><?= htmlspecialchars($item['item_desc']) ?></td>
                                <td><?= htmlspecialchars($item['date_acquired']) ?></td>
                                <td><?= htmlspecialchars($statusMap[$item['item_status']]) ?></td>
                                <td><?= htmlspecialchars($item['item_funds_source']) ?></td>
                                <td><?= htmlspecialchars($item['item_unit_value']) ?></td>
                                <td><?= htmlspecialchars($item['item_quantity']) ?></td>
                                <td><?= htmlspecialchars($item['item_total_value']) ?></td>
                                <td><?= htmlspecialchars($item['item_active']) ?></td>
                                <td><?= htmlspecialchars($item['item_inactive']) ?></td>
                                <td><?= htmlspecialchars($item['history_action'] . ' by ' . $item['history_by'] . ' on ' . formatTimestamp($item['history_modified'], 'M d, Y h:iA ')) ?></td>
                                <td>
                                    <div class="h-full w-full flex items-center gap-2">
                                        <?php require base_path('views/partials/coordinator/school-inventory/edit_item_modal.php') ?>
                                        <?php require base_path('views/partials/coordinator/school-inventory/delete_item_modal.php') ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">
                                <div class="h-full w-full flex items-center gap-2">
                                    No Items Found
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="overflow-hidden">
                    <tr>
                        <td colspan="13" class="py-2 pr-4">
                            <div class="w-full flex items-center justify-end gap-2">
                                <p class="grow text-end mr-2">Page - <?= htmlspecialchars($pagination['pages_current']) ?> / <?= htmlspecialchars($pagination['pages_total']) ?></p>
                                <?php if ($pagination['pages_total'] > 1): ?>
                                    <form
                                        method="POST"
                                        action="/coordinator/school-inventory/<?= $id ?>/s?page=1">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-bar-left"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/school-inventory/<?= $id ?>/s?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-left"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/school-inventory/<?= $id ?>/s?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-right"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/school-inventory/<?= $id ?>/s?page=<?= htmlspecialchars($pagination['pages_total']) ?>">
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