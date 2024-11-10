<?php $page_styles = ['/css/banner.css'];
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/sidebar.php') ?>
<?php require base_path('views/components/text-input.php') ?>
<?php require base_path('views/components/select-input.php') ?>
<?php require base_path('views/components/radio-group.php') ?>


<!-- Your HTML code goes here -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
                    <div class="header-content">
                        <th style="width: 20ch;">
                            <div class="header-content">
                                Item Code
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                            </div>
                        </th>
                        <th style="width: 10ch;">
                            <div class="header-content">
                                Article
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(1)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(1)"></i>
                                </span>
                            </div>
                        </th>
                        <th style="width: 10ch;">
                            <div class="header-content">
                                Description
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(2)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(2)"></i>
                                </span>
                            </div>
                        </th>
                        <th style="width: 12ch;">
                            <div class="header-content">
                                Date Acquired
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(3)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(3)"></i>
                                </span>
                            </div>
                        </th>
                        <th style="width: 11ch;">
                            <div class="header-content">
                                Status
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(4)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(4)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Source of Funds
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(5)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(5)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Unit Value
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(6)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(6)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Qty
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(7)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(7)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Total Value
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(8)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(8)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Active
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(9)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(9)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Inactive
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(10)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(10)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Last Updated
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(11)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(11)"></i>
                                </span>
                            </div>
                        </th>
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

<script>
   let sortOrder = 'asc'; // Initially set to ascending order

   function sortTable(columnIndex) {
      const table = document.querySelector("table tbody");
      const rowsArray = Array.from(table.rows);

      // Toggle the sort order
      sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';

      // Sorting rows
      rowsArray.sort((rowA, rowB) => {
         const cellA = rowA.cells[columnIndex].innerText.trim();
         const cellB = rowB.cells[columnIndex].innerText.trim();

         if (!isNaN(cellA) && !isNaN(cellB)) {
            // Compare numbers
            return sortOrder === 'asc' ? cellA - cellB : cellB - cellA;
         } else {
            // Compare text
            return sortOrder === 'asc' ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
         }
      });

      // Re-append sorted rows to the table
      rowsArray.forEach(row => table.appendChild(row));
   }
</script>