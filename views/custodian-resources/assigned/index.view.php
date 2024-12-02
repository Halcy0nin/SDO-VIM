<?php $page_styles = ['/css/banner.css'];
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/sidebar.php') ?>


<!-- Your HTML code goes here -->

<main class="main-col">
   <section class="flex items-center pr-12 gap-3">
      <?php require base_path('views/partials/banner.php') ?>
   </section>
   <section class="mx-12 flex flex-col">
      <?php require base_path('views/partials/custodian/custodian-resources/tabs.php') ?>
         <form class="search-container search" method="POST" action="/custodian/custodian-resources/assigned/s" > 
            <input type="text" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
            <button type="submit" class="search">
               <i class="bi bi-search"></i>
            </button>
   </section>

         <div class="dropdown-date4">
            <div class="select">
               <span class="selected">Date Range</span>
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
      <div class="date-filter-container5">
         <input type="hidden" name="yearFilter" id="yearFilter" value="">
         <button type="submit" class="filter-button" id="filter-btn">Filter</button>
         <button name="clearFilter" type="submit" class="filter-button" id="filter-btn">Clear Filter</button>
         </form>
      </div>
      <section class="mx-12 mb-12 h-dvh rounded flex flex-col">
      <div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
            <table class="table table-striped m-0">
            <thead>
               <th>ID</th>
               <th>Item Article</th>
               <th>Date Assigned</th>
               <th>Actions</th>
            </thead>
            <tbody>
               <?php foreach ($resources as $resource): ?>
                  <tr>
                     <td><?= htmlspecialchars($resource['item_code']) ?></td>
                     <td><?= htmlspecialchars($resource['item_article']) ?></td>
                     <td><?= htmlspecialchars($resource['item_assigned_date'] ?? '') ?></td>
                     <td>
                        <div class="h-full w-full flex items-center gap-2">
                        <?php require base_path('views/partials/custodian/custodian-resources/assigned_approve_resource_modal.php') ?>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </section>
</main>

<?php require base_path('views/partials/footer.php') ?>

<script>  
// Select both dropdown1 and dropdown-date
const dropdowns = document.querySelectorAll('.dropdown1, .dropdown-date4');

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