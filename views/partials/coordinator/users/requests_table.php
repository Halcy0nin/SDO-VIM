<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<div class="table-responsive inline-block mt-0 bg-zinc-50 rounded border-[1px]">
    <table class="table table-striped">
        <thead>
            <th class="w-[8ch]">
                <div class="header-content">
                    ID
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Requester
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(1)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(1)"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Requested Username
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(2)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(2)"></i>
                    </span>
                </div>
            </th>
            <th class="w-[5ch]">
                <div class="header-content">
                    Date Requested
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(3)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(3)"></i>
                    </span>
                </div>
            </th>
            <?php if ($options ?? false): ?>
                <th class="w-[12ch]">Actions</th>
            <?php endif; ?>
        </thead>
        <tbody>
            <?php if (isset($requests)): ?>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['request_id']) ?></td>
                        <td><?= htmlspecialchars($request['user_name']) ?></td>
                        <td><?= htmlspecialchars($request['new_username']) ?></td>
                        <td><?= htmlspecialchars($request['date_requested']) ?></td>
                        <?php if ($options ?? false): ?>
                            <td>
                                <div class="h-full w-full flex items-center gap-2">
                                    <?php require base_path('views/partials/coordinator/users/approve.php') ?>
                                    <?php require base_path('views/partials/coordinator/users/deny.php') ?>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr rowspan="10" class="h-full">
                    <td colspan="6" class="text-center">
                        There are no Requests.
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
                            <a
                                href="/coordinator/users?page=1"
                                class="pagination-link">
                                <i class="bi bi-chevron-bar-left"></i>
                            </a>
                            <a
                                href="/coordinator/users?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>" class="pagination-link">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                            <a href="/coordinator/users?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>"
                                class="pagination-link">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                            <a href="/coordinator/users?page=<?= htmlspecialchars($pagination['pages_total']) ?>"
                                class="pagination-link">
                                <i class="bi bi-chevron-bar-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

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