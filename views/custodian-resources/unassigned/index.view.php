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
      <section class="flex flex-row justify-between">
            <form class="search-container search" method="POST" action="/custodian/custodian-resources/unassigned/s">
               <input type="text" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
               <button type="submit" class="search">
                  <i class="bi bi-search"></i>
               </button>
            </form>
            <div id="assign_multi_resource" class="search-container" style="display:none">
               <?php require base_path('views/partials/custodian/custodian-resources/assign_multi_resource_modal.php') ?>
            </div>
      </section>
   </section>
      <div class="table-responsive h-full mt-4 bg-zinc-50 rounded border-[1px]">
         <table class="table table-striped">
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