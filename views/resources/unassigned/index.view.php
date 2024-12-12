<?php $page_styles = ['/css/banner.css'];
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/sidebar.php') ?>
<?php require base_path('views/components/text-input.php') ?>

<!-- Your HTML code goes here -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<main class="main-col">
   <section class="flex items-center pr-12 gap-3">
      <?php require base_path('views/partials/banner.php') ?>
      <?php require base_path('views/partials/coordinator/resources/add_resource_modal.php') ?>
      <?php require base_path('views/partials/coordinator/resources/import_resource_modal.php') ?>
   </section>
   <section class="mx-12 flex flex-col">
      <?php require base_path('views/partials/coordinator/resources/tabs.php') ?>
      <section class="flex flex-row justify-between">
         <form class="search-container search" method="POST" action="/coordinator/resources/unassigned/s">
            <input type="text" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
            <button type="submit" class="search">
               <i class="bi bi-search"></i>
            </button>
      </section>
   </section>

   <div class="dropdown-date1">
      <div class="select">
         <span class="selected">Select Year</span>
         <div class="caret"></div>
      </div>
      <ul class="menu">
         <?php foreach ($years as $year): ?>
            <li data-value="<?= htmlspecialchars($year); ?>" onclick="setYearFilter('<?= htmlspecialchars($year); ?>')">
               <?= htmlspecialchars($year); ?>
            </li>
         <?php endforeach; ?>
      </ul>
   </div>
   <div class="date-filter-container7">
      <input type="hidden" name="yearFilter" id="yearFilter" value="">
      <button type="submit" class="filter-button" id="filter-btn">Filter</button>
      <button name="clearFilter" type="submit" class="filter-button" id="filter-btn">Clear Filter</button>
      </form>
   </div>

   <div id="assign_multi_resource" style="display:none">
      <?php require base_path('views/partials/coordinator/resources/assign_multi_resource_modal.php') ?>
   </div>

   <section class="mx-12 mb-12 h-dvh rounded flex flex-col">
      <div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
         <table class="table table-striped m-0">
            <thead>
               <th>
                  <input type="checkbox" id="select-all-button" />
               </th>
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
                     Date Acquired
                     <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(2)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(2)"></i>
                     </span>
                  </div>
               </th>
               
            </thead>
            <tbody>
               <?php if (count($resources) > 0): ?>
                  <?php foreach ($resources as $resource): ?>
                     <tr>
                        <td>
                           <input type="checkbox" value="<?php echo htmlspecialchars($resource['item_code']) ?>" id="select_<?php echo htmlspecialchars($resource['item_code']) ?>" name="selected_items[]" class="item-checkbox" />
                        </td>
                        <td><?= htmlspecialchars($resource['item_code']) ?></td>
                        <td><?= htmlspecialchars($resource['item_article']) ?></td>
                        <td><?= htmlspecialchars(formatTimestamp($resource['date_acquired'])) ?></td>
                     </tr>
                  <?php endforeach; ?>
               <?php else: ?>
                  <tr>
                     <td colspan="6">
                        <div class="h-full w-full flex justify-center items-center py-4">
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
                           <a
                              href="/coordinator/resources/unassigned?page=1"
                              class="pagination-link">
                              <i class="bi bi-chevron-bar-left"></i>
                           </a>
                           <a
                              href="/coordinator/resources/unassigned?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>" class="pagination-link">
                              <i class="bi bi-chevron-left"></i>
                           </a>
                           <a href="/coordinator/resources/unassigned?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>"
                              class="pagination-link">
                              <i class="bi bi-chevron-right"></i>
                           </a>
                           <a href="/coordinator/resources/unassigned?page=<?= htmlspecialchars($pagination['pages_total']) ?>"
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script>
   $(document).ready(function() {
      const assignMultiResource = document.getElementById('assign_multi_resource');

      // Function to update the visibility of the assign_multi_resource section
      function updateStatusFields() {
         const checkedCount = $(".item-checkbox:checked").length;
         assignMultiResource.style.display = checkedCount > 0 ? 'block' : 'none';
      }

      // Event handler for the select-all button
      $("#select-all-button").click(function() {
         $(".item-checkbox").prop('checked', this.checked); // Set all checkboxes
         updateStatusFields(); // Update the display of the resource assignment section
      });

      // Event handler for individual checkbox changes
      $(".item-checkbox").change(function() {
         updateStatusFields(); // Update the display whenever an individual checkbox changes
      });

      // Handle the opening of the modal
      $("#assignResourceModal").on('show.bs.modal', function() {
         // Clear any previous selected items
         $('#selectedItemsContainer').empty();

         // Get the checked checkboxes
         $(".item-checkbox:checked").each(function() {
            const itemCode = $(this).val();
            // Create a hidden input for each selected item
            $('#selectedItemsContainer').append('<input type="hidden" name="selected_items[]" value="' + itemCode + '">');
         });
      });

      // Initial call to set the state of the resource assignment section
      updateStatusFields();
   });
</script>

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

<script>
   // Select both dropdown1 and dropdown-date
   const dropdowns = document.querySelectorAll('.dropdown1, .dropdown-date1');

   dropdowns.forEach(dropdown => {

      const select = dropdown.querySelector('.select');
      const caret = dropdown.querySelector('.caret');
      const menu = dropdown.querySelector('.menu');
      const options = dropdown.querySelectorAll('.menu li'); // Updated to query all list items
      const selected = dropdown.querySelector('.selected');

      // Toggle dropdown menu on select click
      select.addEventListener('click', () => {
         select.classList.toggle('select-clicked');
         caret.classList.toggle('caret-rotate');
         menu.classList.toggle('menu-open');
      });

      // Loop through each option in the menu
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
   // JavaScript function to set the value of the hidden input
   function setYearFilter(year) {
      document.getElementById('yearFilter').value = year;
      document.querySelector('.selected').textContent = year;
   }
</script>