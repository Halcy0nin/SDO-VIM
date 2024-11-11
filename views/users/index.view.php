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
         
         <form id="schoolFilterForm" method="POST" action="/coordinator">
            <input name="_method" value="PATCH" hidden />
            <input id="schoolFilterValue" name="schoolFilterValue" value="All" type="hidden" /> <!-- Hidden input to store selected value -->
            
            <ul class="menu">
                  <li data-value="All">Roles</li> <!-- Default option to show all schools -->
            </ul>
         </form>
   </div>

    </section>
    <section class="mx-12 mb-12 inline-block grow rounded">
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

   const select =dropdown4.querySelector('.select');
   const caret =dropdown4.querySelector('.caret');
   const menu =dropdown4.querySelector('.menu');
   const options =dropdown4.querySelector('.menu li');
   const selected =dropdown4.querySelector('.selected');

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

