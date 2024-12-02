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
         <form class="search-container search" method="POST" action="/custodian/custodian-resources/unassigned/s" > 
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
   </section>
   <section class="mx-12 mb-12 h-dvh rounded flex flex-col">
      <div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
            <table class="table table-striped m-0">
            <thead>
               <th>
                  <input type="checkbox" id="select-all-button" />
               </th>
               <th>ID</th>
               <th>Item Article</th>
               <th>School</th>
               <th>Date Acquired</th>
               <th>Actions</th>
            </thead>
            <tbody>
               <?php foreach ($resources as $resource): ?>
                  <tr>
                     <td>
                        <input type="checkbox" value="<?php echo htmlspecialchars($resource['item_code']) ?>" id="select_<?php echo htmlspecialchars($resource['item_code']) ?>" name="selected_items[]" class="item-checkbox" />
                     </td>
                     <td><?= htmlspecialchars($resource['item_code']) ?></td>
                     <td><?= htmlspecialchars($resource['item_article']) ?></td>
                     <td><?= htmlspecialchars($resource['school_name'] ?? 'Unassigned') ?></td>
                     <td><?= htmlspecialchars(formatTimestamp($resource['date_acquired'])) ?></td>
                     <td>
                        <div class="h-full w-full flex items-center gap-2">
                           <?php require base_path('views/partials/custodian/custodian-resources/assign_resource_modal.php') ?>
                        </div>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
            <tfoot class="overflow-hidden">
                  <tr>
                     <td colspan="6" class="py-2 pr-4">
                        <div class="w-full flex items-center justify-end gap-2">
                           <p class="grow text-end mr-2">Page - <?= htmlspecialchars($pagination['pages_current']) ?> / <?= htmlspecialchars($pagination['pages_total']) ?></p>
                           <?php if ($pagination['pages_total'] > 1): ?>
                              <a
                                 href="/custodian/custodian-resources/unassigned?page=1"
                                 class="pagination-link">
                                 <i class="bi bi-chevron-bar-left"></i>
                              </a>
                              <a
                                 href="/custodian/custodian-resources/unassigned?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>" class="pagination-link">
                                 <i class="bi bi-chevron-left"></i>
                              </a>
                              <a href="/custodian/custodian-resources/unassigned?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>"
                                 class="pagination-link">
                                 <i class="bi bi-chevron-right"></i>
                              </a>
                              <a href="/custodian/custodian-resources/unassigned?page=<?= htmlspecialchars($pagination['pages_total']) ?>"
                                 class="pagination-link">
                                 <i class="bi bi-chevron-bar-right"></i>
                              </a>
                           <?php endif; ?>
                        </div>
                     </td>
                  </tr>
               </tfoot>
         </table>
         </form>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

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