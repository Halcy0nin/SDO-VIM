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
        <?php require base_path('views/partials/custodian/add_receipt_modal.php') ?>
        <?php require base_path('views/partials/custodian/custodian-inventory/add_item_modal.php') ?>
        <?php require base_path('views/partials/custodian/custodian-inventory/export_items_modal.php') ?>
    </section>
    
    <section class="mx-12 flex flex-col">
        <div class="search-container1 search">
        <form class="search-container1 search" method="POST" action="/custodian/custodian-inventory/s">
            <input type="text" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
            <button type="submit" class="search">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </section>

        <div class="dropdown3">
         <div class="select">
            <span class="selected">Filter</span>
            <div class="caret"></div>
         </div>
         
            <input id="statusFilterValue" name="statusFilterValue" value="<?= $statusFilterValue ?>" type="hidden" /> <!-- Hidden input to store selected value -->
            
            <ul class="menu">
                  <li data-value="All">Status</li> 
                  <li data-value="1">Working</li>
                  <li data-value="2">For Repair</li>
                  <li data-value="3">Condemned</li>
            </ul>
   </div>
      <div class="dropdown-date3">
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
      <div class="date-filter-container10">
      <input type="hidden" name="yearFilter" id="yearFilter" value="">
      <button type="submit" class="filter-button" id="filter-btn">Filter</button>
      <button name="clearFilter" type="submit" class="filter-button" id="filter-btn">Clear Filter</button>
      </div>
      </form>
   </div>


   <section class="mx-12 mb-12 inline-block grow rounded">
      <div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
         <table class="table table-striped m-0">
                <thead>
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
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                    <th style="width: 10ch;">
                        <div class="header-content">
                                Description
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                    <th style="width: 12ch;">
                        <div class="header-content">
                                Date Acquired
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                    <th style="width: 10ch;">
                    <div class="header-content">
                        Warranty End Date
                        <span class="sort-icons">
                            <i class="fas fa-sort-up sort-icon" onclick=" sortTable(1)"></i>
                            <i class="fas fa-sort-down sort-icon" onclick=" sortTable(1)"></i>
                        </span>
                    </div>
                </th>
                <th style="width: 10ch;">
                    <div class="header-content">
                        Warranty Status
                        <span class="sort-icons">
                            <i class="fas fa-sort-up sort-icon" onclick=" sortTable(1)"></i>
                            <i class="fas fa-sort-down sort-icon" onclick=" sortTable(1)"></i>
                        </span>
                    </div>
                </th>
                    <th style="width: 11ch;">
                        <div class="header-content">
                                Status
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                    <th>
                        <div class="header-content">
                                Source of Funds
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                    <th>
                        <div class="header-content">
                                Unit Value
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                    <th>
                        <div class="header-content">
                                Qty
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                    <th>
                        <div class="header-content">
                                Total Value
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                    <th>
                        <div class="header-content">
                                Active
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                    <th>
                        <div class="header-content">
                                Inactive
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                    <th>
                        <div class="header-content">
                                Last Updated
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                    <th>
                        <div class="header-content">
                                Action
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                                </span>
                        </div>
                    </th>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['item_code']) ?></td>
                            <td><?= htmlspecialchars($item['item_article']) ?></td>
                            <td><?= htmlspecialchars($item['item_desc']) ?></td>
                            <td><?= htmlspecialchars($item['date_acquired']) ?></td>
                            <td><?= htmlspecialchars($item['warranty_end']) ?></td>
                            <?php if (date('Y-m-d') >= $item['warranty_end']): ?>
                                <td>Expired</td>
                            <?php else: ?>
                                <td>Active</td>
                            <?php endif; ?>
                            <td><?= htmlspecialchars($statusMap[$item['item_status']]) ?></td>
                            <td><?= htmlspecialchars($item['item_funds_source']) ?></td>
                            <td><?= htmlspecialchars($item['item_unit_value']) ?></td>
                            <td><?= htmlspecialchars($item['item_quantity']) ?></td>
                            <td><?= htmlspecialchars($item['item_total_value']) ?></td>
                            <td><?= htmlspecialchars($item['item_active']) ?></td>
                            <td><?= htmlspecialchars($item['item_inactive']) ?></td>
                            <td>
                                <?php
                                foreach ($histories as $history):
                                    if ($history['item_code'] == $item['item_code']) {
                                        echo htmlspecialchars($history['action'] . ' by ' . $history['user_name'] . ' on ' . $history['modified_at']);
                                    }
                                endforeach;
                                ?>
                            </td>
                            <td>
                                <div class="h-full w-full flex items-center gap-2">
                                    <?php require base_path('views/partials/custodian/custodian-inventory/edit_item_modal.php') ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="overflow-hidden">
                    <tr>
                        <td colspan="15" class="py-2 pr-4">
                            <div class="w-full flex items-center justify-end gap-2">
                                <p class="grow text-end mr-2">Page - <?= htmlspecialchars($pagination['pages_current']) ?> / <?= htmlspecialchars($pagination['pages_total']) ?></p>
                                <?php if ($pagination['pages_total'] > 1): ?>
                                    <a
                                        href="/custodian/custodian-inventory?page=1"
                                        class="pagination-link">
                                        <i class="bi bi-chevron-bar-left"></i>
                                    </a>
                                    <a
                                        href="/custodian/custodian-inventory?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>" class="pagination-link">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                    <a href="/custodian/custodian-inventory?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>"
                                        class="pagination-link">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                    <a href="/custodian/custodian-inventory?page=<?= htmlspecialchars($pagination['pages_total']) ?>"
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
// Select both dropdown1 and dropdown-date
const dropdowns = document.querySelectorAll('.dropdown3, .dropdown-date3');

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
    // JavaScript function to set the value of the hidden input
    function setYearFilter(year) {
      // Update the hidden input value for yearFilter
    const yearFilterInput = document.getElementById('yearFilter');
    if (yearFilterInput) {
        yearFilterInput.value = year;
    }

    // Update the display text specifically for yearFilter
    const yearFilterDisplay = document.querySelector('.yearFilter .selected');
    if (yearFilterDisplay) {
        yearFilterDisplay.textContent = year;
    }
    }
</script>

<script>
    // JavaScript function to set the value of the hidden input for statusFilterValue
    function setStatusFilter(value, text) {
        // Update the hidden input value for statusFilterValue
        const statusFilterInput = document.getElementById('statusFilterValue');
        if (statusFilterInput) {
            statusFilterInput.value = value; // Set the value to the data-value
        }

        // Update the display text specifically for statusFilterValue
        const statusFilterDisplay = document.querySelector('.dropdown2 .selected');
        if (statusFilterDisplay) {
            statusFilterDisplay.textContent = text; // Set the text to the clicked item's inner text
        }
    }

    // Event listener for dropdown items
    document.querySelectorAll('.dropdown3 .menu li').forEach(item => {
        item.addEventListener('click', function () {
            const value = this.getAttribute('data-value'); // Get the data-value
            const text = this.textContent; // Get the display text

            // Call setStatusFilter with the selected value and text
            setStatusFilter(value, text);
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
