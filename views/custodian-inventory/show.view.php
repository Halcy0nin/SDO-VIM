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
      <?php require base_path('views/partials/custodian/custodian-inventory/add_item_modal.php') ?>
      <?php require base_path('views/partials/custodian/custodian-inventory/export_items_modal.php') ?>
   </section>
   <section class="mx-12 mt-12 mb-12 h-dvh rounded flex flex-col">
      <form class="search-container1 search" method="POST" action="/custodian/custodian-inventory/s">
         <input type="text" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
         <button type="submit" class="search">
            <i class="bi bi-search"></i>
         </button>
      </form>
      <div class="sort2">
         <div class="select">
         <span class="selected">Sort by</span>
            <div class="caret"></div>
         </div>
         <ul class="menu">
            <li>Item Article</li>
            <li>Date Acquired</li>
         </ul>
      </div>
   <section class="table-responsive h-dvh bg-zinc-50 rounded border-[1px]">
      <table class="table table-striped">
         <thead>
        <tr>
            <th>
                <div class="header-content">
                    Item Code
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(0, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(0, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Article
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(1, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(1, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Description
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(2, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(2, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Date Acquired
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(3, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(3, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Status
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(4, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(4, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Source of Funds
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(5, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(5, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Unit Value
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(6, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(6, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Qty.
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(7, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(7, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Total Value
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(8, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(8, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Active
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(9, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(9, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Inactive
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(10, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(10, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Last Updated
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick="sortTable(11, 'asc')"></i>
                        <i class="fas fa-sort-down sort-icon" onclick="sortTable(11, 'desc')"></i>
                    </span>
                </div>
            </th>
            <th>Action</th>
        </tr>
         </thead>
         <tbody>
         <?php foreach ($items as $item): ?>
               <tr>
                    <td><?= htmlspecialchars($item['item_code']) ?></td>
                    <td><?= htmlspecialchars($item['item_article']) ?></td>
                    <td><?= htmlspecialchars($item['item_desc']) ?></td>
                    <td><?= htmlspecialchars($item['date_acquired']) ?></td>
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
                        <?php require base_path('views/partials/custodian/custodian-inventory/delete_item_modal.php') ?>
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
                            <form
                              method="POST"
                              action="/custodian/custodian-inventory/s?page=1">
                              <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                              <button class="pagination-link" type="submit"><i class="bi bi-chevron-bar-left"></i></button>
                           </form>
                           <form
                              method="POST"
                              action="/custodian/custodian-inventory/s?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>">
                              <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                              <button class="pagination-link" type="submit"><i class="bi bi-chevron-left"></i></button>
                           </form>
                           <form
                              method="POST"
                              action="/custodian/custodian-inventory/s?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>">
                              <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                              <button class="pagination-link" type="submit"><i class="bi bi-chevron-right"></i></button>
                           </form>
                           <form
                              method="POST"
                              action="/custodian/custodian-inventory/s?page=<?= htmlspecialchars($pagination['pages_total']) ?>">
                              <input type="hidden" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
                              <button class="pagination-link" type="submit"><i class="bi bi-chevron-bar-right"></i></button>
                           </form>
                        <?php endif; ?>
                     </div>
                  </td>
               </tr>
            </tfoot>
      </table>
   </section>
</main>
<?php require base_path('views/partials/footer.php') ?>

<script>  
   const dropdowns = document.querySelectorAll('.sort2');

   dropdowns.forEach(sort2 => {

      const select =sort2.querySelector('.select');
      const caret =sort2.querySelector('.caret');
      const menu =sort2.querySelector('.menu');
      const options =sort2.querySelector('.menu li');
      const selected =sort2.querySelector('.selected');

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

<script>
function sortTable(columnIndex, sortOrder) {
    const table = document.querySelector("table tbody");
    const rowsArray = Array.from(table.rows);

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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

