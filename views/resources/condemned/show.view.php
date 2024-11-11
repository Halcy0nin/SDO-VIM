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
        <?php require base_path('views/partials/coordinator/resources/add_resource_modal.php') ?>
        <?php require base_path('views/partials/coordinator/resources/import_resource_modal.php') ?>
    </section>
    <section class="mx-12 flex flex-col">
        <?php require base_path('views/partials/coordinator/resources/tabs.php') ?>
        <form class="search-container search" method="POST" action="/coordinator/resources/condemned/s">
            <input type="text" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
            <button type="submit" class="search">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </section>
    <div class="date-filter-container3">
      <form method="POST" action="/coordinator/resources/s" >
      <input name="_method" value="PATCH" hidden />
         <label for="start-date">Start Date:</label>
         <input value="<?= htmlspecialchars($startDate) ?>" type="date" id="start-date"  name="startDate" />

         <label for="end-date">End Date:</label>
         <input value="<?= htmlspecialchars($endDate) ?>" type="date" id="end-date"  name="endDate" required />

         <button type="submit" class="filter-button" id="filter-btn">Filter</button>
         <button name="clearFilter" type="submit" class="filter-button" id="filter-btn">Clear Filter</button>
      </form>
  </div>
    <section class="mx-12 mb-12 inline-block grow rounded">
        <div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
            <table class="table table-striped m-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Article</th>
                        <th>School</th>
                        <th>Date Acquired</th>
                        <th>No. Of Items</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="oveflow-y-scroll">
                    <?php if (count($resources) > 0): ?>
                        <?php foreach ($resources as $resource): ?>
                            <tr>
                                <td><?= htmlspecialchars($resource['item_code']) ?></td>
                                <td><?= htmlspecialchars($resource['item_article']) ?></td>
                                <td><?= htmlspecialchars($resource['school_name']) ?></td>
                                <td><?= htmlspecialchars(formatTimestamp($resource['date_acquired'])) ?></td>
                                <td><?= htmlspecialchars($resource['item_inactive']) ?></td>
                                <td>
                                    <div class="h-full w-full flex items-center gap-2">
                                    <?php require base_path('views/partials/coordinator/resources/view_condemned_modal.php') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">
                                <div class="h-full w-full flex items-center gap-2">
                                    No Resources Found
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="overflow-hidden">
                    <tr>
                        <td colspan="6" class="py-2 pr-4">
                            <div class="w-full flex items-center justify-end gap-2">
                                <p class="grow text-end mr-2">Page - <?= htmlspecialchars($pagination['pages_current']) ?> / <?= htmlspecialchars($pagination['pages_total']) ?></p>
                                <?php if ($pagination['pages_total'] > 1): ?>
                                    <form
                                        method="POST"
                                        action="/coordinator/resources/condemned/s?page=1">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-bar-left"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/resources/condemned/s?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-left"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/resources/condemned/s?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-right"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/resources/condemned/s?page=<?= htmlspecialchars($pagination['pages_total']) ?>">
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