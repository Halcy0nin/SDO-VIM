<?php $page_styles = ['/css/banner.css'];
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/sidebar.php') ?>


<!-- Your HTML code goes here -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<main class="main-col">
   <section class="flex items-center pr-12 gap-3">
      <?php require base_path('views/partials/banner.php') ?>
   </section>
   <section class="mx-12 mb-12 h-dvh rounded flex flex-col">
      <?php require base_path('views/partials/custodian/custodian-resources/tabs.php') ?>
      <form class="search-container search" method="POST" action="/custodian/custodian-resources/s">
         <input type="text" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
         <button type="submit" class="search">
            <i class="bi bi-search"></i>
         </button>
      </form>
      <div class="table-responsive h-full mt-4 bg-zinc-50 rounded border-[1px]">
         <table class="table table-striped">
            <thead>
               <tr>
                  <th>
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
                        Item Article
                        <span class="sort-icons">
                           <i class="fas fa-sort-up sort-icon" onclick=" sortTable(1)"></i>
                           <i class="fas fa-sort-down sort-icon" onclick=" sortTable(1)"></i>
                        </span>
                     </div>
                  </th>
                  <th>
                     <div class="header-content">
                        School
                        <span class="sort-icons">
                           <i class="fas fa-sort-up sort-icon" onclick=" sortTable(2)"></i>
                           <i class="fas fa-sort-down sort-icon" onclick=" sortTable(2)"></i>
                        </span>
                     </div>
                  </th>
                  <th>
                     <div class="header-content">
                        Status
                        <span class="sort-icons">
                           <i class="fas fa-sort-up sort-icon" onclick=" sortTable(3)"></i>
                           <i class="fas fa-sort-down sort-icon" onclick=" sortTable(3)"></i>
                        </span>
                     </div>
                  </th>
                  <th>
                     <div class="header-content">
                        Date Acquired
                        <span class="sort-icons">
                           <i class="fas fa-sort-up sort-icon" onclick=" sortTable(4)"></i>
                           <i class="fas fa-sort-down sort-icon" onclick=" sortTable(4)"></i>
                        </span>
                     </div>
                  </th>
                  <th>
                     Action
                  </th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($resources as $resource): ?>
                  <tr>
                     <td><?= htmlspecialchars($resource['item_code']) ?></td>
                     <td><?= htmlspecialchars($resource['item_article']) ?></td>
                     <td><?= htmlspecialchars($resource['school_name']) ?></td>
                     <td><?= htmlspecialchars($statusMap[$resource['status']]) ?></td>
                     <td><?= htmlspecialchars(formatTimestamp($resource['date_acquired'])) ?></td>
                     <td>
                        <div class="h-full w-full flex items-center gap-2">
                           <button class="view-btn">
                              <i class="bi bi-eye-fill"></i>
                           </button>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
            <tfoot class="overflow-hidden">
               <tr>
                  <td colspan="6" class="py-2 pr-4">
                     <div class="w-full flex flex-wrap items-center justify-end gap-2">
                        <p class="grow text-end mr-2">Page - <?= htmlspecialchars($pagination['pages_current']) ?> / <?= htmlspecialchars($pagination['pages_total']) ?></p>
                        <?php if ($pagination['pages_total'] > 1): ?>
                           <form
                              method="POST"
                              action="/custodian/custodian-resources/s?page=1">
                              <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                              <button class="pagination-link" type="submit"><i class="bi bi-chevron-bar-left"></i></button>
                           </form>
                           <form
                              method="POST"
                              action="/custodian/custodian-resources/s?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>">
                              <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                              <button class="pagination-link" type="submit"><i class="bi bi-chevron-left"></i></button>
                           </form>
                           <form
                              method="POST"
                              action="/custodian/custodian-resources/s?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>">
                              <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                              <button class="pagination-link" type="submit"><i class="bi bi-chevron-right"></i></button>
                           </form>
                           <form
                              method="POST"
                              action="/custodian/custodian-resources/s?page=<?= htmlspecialchars($pagination['pages_total']) ?>">
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>