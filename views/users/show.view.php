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
        <?php require base_path('views/partials/coordinator/users/add_user_modal.php') ?>
        <?php require base_path('views/partials/coordinator/users/import_user_modal.php') ?>
        <?php require base_path('views/partials/coordinator/users/export_user_modal.php') ?>
    </section>
    <section class="mx-12 flex flex-col">
        <?php require base_path('views/partials/coordinator/users/tabs.php') ?>
        <form class="search-container search" method="POST" action="/coordinator/users/s">
            <input type="text" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
            <button type="submit" class="search">
                <i class="bi bi-search"></i>
            </button>
        </form>
        
    <div class="dropdown4">
         <div class="select">
            <span class="selected">Roles</span>
            <div class="caret"></div>
         </div>
      
         <input id="roleFilterValue" name="roleFilterValue" value="<?= $roleFilterValue ?>" type="hidden" />
            
            <ul class="menu">
                  <li data-value="All">Roles</li>
                  <li data-value="1">Coordinator</li>
                  <li data-value="2">Custodian</li> <!-- Default option to show all schools -->
            </ul>
   </div>
   
    <section class="mx-14 mb-14 inline-block grow rounded">
        <div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
            <table class="table table-striped m-0">
                <thead>
                    <th class="w-[5ch]">
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
                            Username
                            <span class="sort-icons">
                                <i class="fas fa-sort-up sort-icon" onclick=" sortTable(1)"></i>
                                <i class="fas fa-sort-down sort-icon" onclick=" sortTable(1)"></i>
                            </span>
                        </div>
                    </th>
                    <th class="w-[12ch]">
                        <div class="header-content">
                            Role
                            <span class="sort-icons">
                                <i class="fas fa-sort-up sort-icon" onclick=" sortTable(2)"></i>
                                <i class="fas fa-sort-down sort-icon" onclick=" sortTable(2)"></i>
                            </span>
                        </div>
                    </th>
                    <th>
                        <div class="header-content">
                            School
                            <span class="sort-icons">
                                <i class="fas fa-sort-up sort-icon" onclick=" sortTable(3)"></i>
                                <i class="fas fa-sort-down sort-icon" onclick=" sortTable(3)"></i>
                            </span>
                        </div>
                    </th>
                    <th>
                        <div class="header-content">
                            Contact Name
                            <span class="sort-icons">
                                <i class="fas fa-sort-up sort-icon" onclick=" sortTable(4)"></i>
                                <i class="fas fa-sort-down sort-icon" onclick=" sortTable(4)"></i>
                            </span>
                        </div>
                    </th>
                    <th class="w-[16ch]">
                        <div class="header-content">
                            Mobile Number
                            <span class="sort-icons">
                                <i class="fas fa-sort-up sort-icon" onclick=" sortTable(5)"></i>
                                <i class="fas fa-sort-down sort-icon" onclick=" sortTable(5)"></i>
                            </span>
                        </div>
                    </th>
                    <th class="w-[24ch]">
                        <div class="header-content">
                            Email
                            <span class="sort-icons">
                                <i class="fas fa-sort-up sort-icon" onclick=" sortTable(6)"></i>
                                <i class="fas fa-sort-down sort-icon" onclick=" sortTable(6)"></i>
                            </span>
                        </div>
                    </th>
                    <th class="w-[12ch]">
                        <div class="header-content">
                            Date Added
                            <span class="sort-icons">
                                <i class="fas fa-sort-up sort-icon" onclick=" sortTable(7)"></i>
                                <i class="fas fa-sort-down sort-icon" onclick=" sortTable(7)"></i>
                            </span>
                        </div>
                    </th>
                    <th class="w-[12ch]">
                        <div class="header-content">
                            Date Modified
                            <span class="sort-icons">
                                <i class="fas fa-sort-up sort-icon" onclick=" sortTable(8)"></i>
                                <i class="fas fa-sort-down sort-icon" onclick=" sortTable(8)"></i>
                            </span>
                        </div>
                    </th>
                    <th class="w-[16ch]">Actions</th>
                </thead>
                <tbody>
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['user_id']) ?></td>
                                <td><?= htmlspecialchars($user['user_name']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td><?= htmlspecialchars($user['school'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['contact_name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['contact_no'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['contact_email'] ?? '') ?></td>
                                <td><?= htmlspecialchars(formatTimestamp($user['date_added'])) ?></td>
                                <td><?= htmlspecialchars(formatTimestamp($user['date_modified'])) ?></td>
                                <td>
                                    <div class="h-full w-full flex items-center gap-2">
                                        <?php require base_path('views/partials/coordinator/users/password_change_modal.php') ?>
                                        <?php require base_path('views/partials/coordinator/users/edit_user_modal.php') ?>
                                        <?php require base_path('views/partials/coordinator/users/delete_user_modal.php') ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">
                                <div class="h-full w-full flex items-center gap-2">
                                    No Users Found
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
                                        action="/coordinator/users/s?page=1">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-bar-left"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/users/s?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-left"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/users/s?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>">
                                        <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                                        <button class="pagination-link" type="submit"><i class="bi bi-chevron-right"></i></button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="/coordinator/users/s?page=<?= htmlspecialchars($pagination['pages_total']) ?>">
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

<script>
    // JavaScript function to set the value of the hidden input for roleFilterValue
    function setroleFilter(value, text) {
        // Update the hidden input value for roleFilterValue
        const roleFilterInput = document.getElementById('roleFilterValue');
        if (roleFilterInput) {
            roleFilterInput.value = value; // Set the value to the data-value
        }

        // Update the display text specifically for roleFilterValue
        const roleFilterDisplay = document.querySelector('.dropdown2 .selected');
        if (roleFilterDisplay) {
            roleFilterDisplay.textContent = text; // Set the text to the clicked item's inner text
        }
    }

    // Event listener for dropdown items
    document.querySelectorAll('.dropdown4 .menu li').forEach(item => {
        item.addEventListener('click', function () {
            const value = this.getAttribute('data-value'); // Get the data-value
            const text = this.textContent; // Get the display text

            // Call setroleFilter with the selected value and text
            setroleFilter(value, text);
        });
    });
</script>