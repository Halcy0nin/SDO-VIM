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
            <span class="selected">Filter</span>
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
        <?php require base_path('views/partials/coordinator/users/users_table.php') ?>
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

