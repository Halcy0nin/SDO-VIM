<?php $page_styles = ['/css/banner.css'];
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/sidebar.php') ?>
<?php require base_path('views/components/text-input.php') ?>

<!-- Your HTML code goes here -->

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
            <div id="assign_multi_resource" class="search-container" style="display:none">
               <?php require base_path('views/partials/coordinator/resources/assign_multi_resource_modal.php') ?>
            </div>
      </section>
   </section>

   <div class="dropdown-date1">
            <div class="select">
               <span class="selected">Date Range</span>
               <div class="caret"></div>
            </div>
            
            <form id="schoolFilterForm" method="POST" action="/coordinator">
               <input name="_method" value="PATCH" hidden />
               <input id="schoolFilterValue" name="schoolFilterValue" value="<?= htmlspecialchars($schoolName ?? 'All School') ?>" type="hidden" />
               
               <ul class="menu">
                     <li data-value="All School">All Schools</li> <!-- Default option to show all schools -->
                     <?php foreach ($schoolDropdownContent as $school): ?>
                        <li data-value="<?= htmlspecialchars($school['school_name']); ?>">
                           <?= htmlspecialchars($school['school_name']); ?>
                        </li>
                     <?php endforeach; ?>
               </ul>
   </div>

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
                  <?php if (count($resources) > 0): ?>
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
                                 <?php require base_path('views/partials/coordinator/resources/assign_resource_modal.php') ?>
                              </div>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  <?php else: ?>
                     <tr>
                        <td colspan="5">
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


