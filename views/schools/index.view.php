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
        <?php require base_path('views/partials/coordinator/schools/archived_schools_button.php') ?>
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
    </section>

    <div class="dropdown4">
         <div class="select">
            <span class="selected">District</span>
            <div class="caret"></div>
         </div>
      
         <input id="districtFilterValue" name="districtFilterValue" value="<?= $districtFilterValue ?>" type="hidden" />
            
            <ul class="menu">
                  <li data-value="All">All</li>
                  <li data-value="1">Congressional I</li>
                  <li data-value="2">Congressional II</li> <!-- Default option to show all schools -->
            </ul>
        </div>
        <div class="date-filter-container7">
        <input type="hidden" name="yearFilter" id="yearFilter" value="">
        <button type="submit" class="filter-button" id="filter-btn">Filter</button>
        <button name="clearFilter" type="submit" class="filter-button" id="filter-btn">Clear Filter</button>

      </form>
   </div>

   </div>
    <section class="mx-12 mb-12 inline-block grow rounded">
        <div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
            <table class="table table-striped m-0">
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
                                Name
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(1)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(1)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Type
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(2)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(2)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Division
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(3)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(3)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                District
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(4)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(4)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Contact Name
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(5)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(5)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Contact Number
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(6)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(6)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Contact Email
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(7)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(7)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            <div class="header-content">
                                Date Added
                                <span class="sort-icons">
                                    <i class="fas fa-sort-up sort-icon" onclick=" sortTable(8)"></i>
                                    <i class="fas fa-sort-down sort-icon" onclick=" sortTable(8)"></i>
                                </span>
                            </div>
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
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
                                        <!-- hide view receipt temporarily -->
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
                                    <a
                                        href="/coordinator/schools?page=1"
                                        class="pagination-link">
                                        <i class="bi bi-chevron-bar-left"></i>
                                    </a>
                                    <a
                                        href="/coordinator/schools?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>" class="pagination-link">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                    <a href="/coordinator/schools?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>"
                                        class="pagination-link">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                    <a href="/coordinator/schools?page=<?= htmlspecialchars($pagination['pages_total']) ?>"
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
const dropdowns = document.querySelectorAll('.dropdown4');

dropdowns.forEach(dropdown4 => {
    const select = dropdown4.querySelector('.select');
    const caret = dropdown4.querySelector('.caret');
    const menu = dropdown4.querySelector('.menu');
    const options = dropdown4.querySelectorAll('.menu li'); // Corrected to select all `li` elements
    const selected = dropdown4.querySelector('.selected');

    // Toggle dropdown menu visibility
    select.addEventListener('click', () => {
        select.classList.toggle('select-clicked');
        caret.classList.toggle('caret-rotate');
        menu.classList.toggle('menu-open');
    });

    // Add click event listener to each option
    options.forEach(option => {
        option.addEventListener('click', () => {
            selected.innerText = option.innerText; // Update displayed text
            select.classList.remove('select-clicked');
            caret.classList.remove('caret-rotate');
            menu.classList.remove('menu-open');
            options.forEach(opt => opt.classList.remove('active')); // Remove active class from all
            option.classList.add('active'); // Add active class to clicked option

            // Update hidden input value
            const value = option.getAttribute('data-value');
            const roleFilterInput = document.getElementById('roleFilterValue');
            if (roleFilterInput) {
                roleFilterInput.value = value;
            }
        });
    });
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
    // JavaScript function to set the value of the hidden input for districtFilterValue
    function setDistrictFilter(value, text) {
        // Update the hidden input value for districtFilterValue
        const districtFilterInput = document.getElementById('districtFilterValue');
        if (districtFilterInput) {
            districtFilterInput.value = value; // Set the value to the data-value
        }

        // Update the display text specifically for districtFilterValue
        const districtFilterDisplay = document.querySelector('.dropdown4 .selected');
        if (districtFilterDisplay) {
            districtFilterDisplay.textContent = text; // Set the text to the clicked item's inner text
        }
    }

    // Event listener for dropdown items
    document.querySelectorAll('.dropdown4 .menu li').forEach(item => {
        item.addEventListener('click', function () {
            const value = this.getAttribute('data-value'); // Get the data-value
            const text = this.textContent; // Get the display text

            // Call setDistricFilter with the selected value and text
            setDistrictFilter(value, text);
        });
    });
</script>