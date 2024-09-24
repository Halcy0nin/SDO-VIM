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
      </form>

      <div class="dropdown">
         <div class="select">
            <span class="selected">Filter</span>
            <div class="caret"></div>
         </div>
         <ul class="menu">
            <li>School</li>
            <li>School1</li>
            <li>School2</li>
            <li>School3</li>
         </ul>
      </div>

   </section>
   <section class="mx-12 mb-12 inline-block grow rounded">
      <div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
         <table class="table table-striped m-0">
            <thead>
               <th>ID</th>
               <th>Name</th>
               <th>Type</th>
               <th>Division</th>
               <th>District</th>
               <th>Contact Name</th>
               <th>Contact Number</th>
               <th>Contact Email</th>
               <th>Date Added</th>
               <th>Actions</th>
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
const dropdowns = document.querySelectorAll('.dropdown');

dropdowns.forEach(dropdown => {
  const select = dropdown.querySelector('.select');
  const caret = dropdown.querySelector('.caret');
  const menu = dropdown.querySelector('.menu');
  const options = dropdown.querySelectorAll('.menu li'); // Fixed query to select all <li>
  const selected = dropdown.querySelector('.selected');

  // Toggle dropdown open/close when the select box is clicked
  select.addEventListener('click', () => {
    select.classList.toggle('select-clicked');
    caret.classList.toggle('caret-rotate');
    menu.classList.toggle('menu-open');
  });

  // Iterate through each option (list item) in the menu
  options.forEach(option => {
    option.addEventListener('click', () => {
      // Update the selected text with the clicked option's text
      selected.innerText = option.innerText;

      // Close the dropdown by removing the toggled classes
      select.classList.remove('select-clicked');
      caret.classList.remove('caret-rotate');
      menu.classList.remove('menu-open');

      // Remove the 'active' class from all options
      options.forEach(option => {
        option.classList.remove('active');
      });

      // Add 'active' class to the clicked option
      option.classList.add('active');
    });
  });
});

// Close the dropdown if clicked outside
document.addEventListener('click', function(e) {
  dropdowns.forEach(dropdown => {
    if (!dropdown.contains(e.target)) {
      const select = dropdown.querySelector('.select');
      const caret = dropdown.querySelector('.caret');
      const menu = dropdown.querySelector('.menu');

      // Ensure dropdown is closed if clicked outside
      select.classList.remove('select-clicked');
      caret.classList.remove('caret-rotate');
      menu.classList.remove('menu-open');
    }
  });
});
</script> 