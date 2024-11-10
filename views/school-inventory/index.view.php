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

   <div class="dropdown2">
      <div class="select">
         <span class="selected">Filter</span>
         <div class="caret"></div>
      </div>

      <form id="schoolFilterForm" method="POST" action="/coordinator">
         <input name="_method" value="PATCH" hidden />
         <input id="schoolFilterValue" name="schoolFilterValue" value="All" type="hidden" /> <!-- Hidden input to store selected value -->

         <ul class="menu">
            <li data-value="All">Status</li> <!-- Default option to show all schools -->
         </ul>
      </form>
   </div>

   <?php $currentOrder = $_GET['order'] ?? 'asc';
   $nextOrders = getNextOrder($currentOrder); ?>

   <section class="mx-12 flex flex-col">
      <form class="search-container2 search" method="POST" action="/coordinator/school-inventory/<?= $id ?>/s">
         <input type="text" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
         <button type="submit" class="search">
            <i class="bi bi-search"></i>
         </button>
      </form>
   </section>

   <div class="date-filter-container2">
      <h1 style="font-weight: bold; color: #434F72">Publishing Date MM/DD/YYYY</h1>
      <input type="date" id="start-date" />
      <label for="end-date">to</label>
      <input type="date" id="end-date" />
      <button class="filter-button" id="filter-btn">Filter</button>
   </div>
   <section class="mx-12 mb-12 inline-block grow rounded">
      <div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
         <table class="table table-striped m-0">
            <thead>
               <th style="width: 20ch;">
                  <div class="header-content">
                     Item Code
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=item_code&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=item_code&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th style="width: 10ch;">
                  <div class="header-content">
                     Article
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=article&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=article&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th style="width: 10ch;">
                  <div class="header-content">
                     Description
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=description&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=description&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th style="width: 12ch;">
                  <div class="header-content">
                     Date Acquired
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=date_acquired&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=date_acquired&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th style="width: 11ch;">
                  <div class="header-content">
                     Status
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=status&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=status&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th>
                  <div class="header-content">
                     Source of Funds
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=source_of_funds&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=source_of_funds&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th>
                  <div class="header-content">
                     Unit Value
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=unit_value&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=unit_value&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th>
                  <div class="header-content">
                     Qty
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=qty&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=qty&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th>
                  <div class="header-content">
                     Total Value
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=total_value&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=total_value&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th>
                  <div class="header-content">
                     Active
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=active&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=active&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th>
                  <div class="header-content">
                     Inactive
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=inactive&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=inactive&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th>
                  <div class="header-content">
                     Last Updated
                     <span class="sort-icons1">
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=last_updated&order=<?= $nextOrders['asc'] ?>">
                           <i class="fas fa-sort-up"></i>
                        </a>
                        <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= $pagination['pages_current'] ?>&sort=last_updated&order=<?= $nextOrders['desc'] ?>">
                           <i class="fas fa-sort-down"></i>
                        </a>
                     </span>
                  </div>
               </th>
               <th>
                  <div class="header-content">
                     Action
                  </div>
               </th>
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
                           <a
                              href="/coordinator/school-inventory/<?= $id ?>?page=1"
                              class="pagination-link">
                              <i class="bi bi-chevron-bar-left"></i>
                           </a>
                           <a
                              href="/coordinator/school-inventory/<?= $id ?>?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>" class="pagination-link">
                              <i class="bi bi-chevron-left"></i>
                           </a>
                           <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>"
                              class="pagination-link">
                              <i class="bi bi-chevron-right"></i>
                           </a>
                           <a href="/coordinator/school-inventory/<?= $id ?>?page=<?= htmlspecialchars($pagination['pages_total']) ?>"
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
   </section>

</main>
<?php require base_path('views/partials/footer.php') ?>

<script>
   function sortTable(columnIndex, sortOrder) {
      const table = document.querySelector("table tbody");
      const rowsArray = Array.from(table.rows);

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

<script>
   const dropdowns = document.querySelectorAll('.dropdown2');

   dropdowns.forEach(dropdown2 => {

      const select = dropdown2.querySelector('.select');
      const caret = dropdown2.querySelector('.caret');
      const menu = dropdown2.querySelector('.menu');
      const options = dropdown2.querySelector('.menu li');
      const selected = dropdown2.querySelector('.selected');

      select.addEventListener('click', () => {

         select.classList.toggle('select-clicked');
         caret.classList.toggle('caret-rotate');
         menu.classList.toggle('menu-open');
      });



      options.forEach(option => {

         option.addEventListener('click', () => {

            selected.innerText = option.innerText;
            select.classList.remove('select-clicked');
            caret.classList.remove('caret-rotate');
            menu.classList.remove('menu-open');
            options.forEach(option => {
               option.classList.remove('active');
            });
            option.classList.add('active');
         });
      });
   });
</script>

<script>
   document.querySelectorAll('.menu li').forEach(function(item) {
      item.addEventListener('click', function() {
         const selectedValue = this.getAttribute('data-value'); // Get the value from the clicked <li>
         document.getElementById('schoolFilterValue').value = selectedValue; // Set the hidden input value
         document.getElementById('schoolFilterForm').submit(); // Submit the form
      });
   });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
   // JavaScript to handle button click event
   document.getElementById('filter-btn').addEventListener('click', function() {
      const startDate = document.getElementById('start-date').value;
      const endDate = document.getElementById('end-date').value;

      if (startDate && endDate) {
         alert(`Filtering from ${startDate} to ${endDate}`);
      } else {
         alert('Please select both start and end dates.');
      }
   });
</script>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>