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
      <?php require base_path('views/partials/coordinator/resources/add_resource_modal.php') ?>
      <?php require base_path('views/partials/coordinator/resources/import_resource_modal.php') ?>
   </section>
   <section class="mx-12 flex flex-col">
      <?php require base_path('views/partials/coordinator/resources/tabs.php') ?>
      <form class="search-container search" method="POST" action="/coordinator/resources/s">
         <input type="text" name="search" id="search" placeholder="Search" value="<?= $search ?? '' ?>" />
         <button type="submit" class="search">
            <i class="bi bi-search"></i>
         </button>
      </form>
   </section>
   <section class="mx-12 mb-12 inline-block grow rounded">
      <div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
         <table class="table table-striped m-0">
            <thead>
            <style>
               th {
                     position: relative;
                     padding: 10px;
                     color:black;
               }
               th .dropdown {
                     display: inline-block;
                     line-height: 2rem;
                     margin-left: 5px;
               }
               th .fas {
                     margin-left: 0.5rem;
                     min-width: 100px;
               }
               .dropdown-menu {
                     min-width: 100px;
                     color:white;
               }
               .dropdown-toggle {
                  background-color: white;
                  color: black;
               }
               .dropdown-toggle:hover {
                  background-color: #434F72;
               }
               .dropdown-item:hover {
                  background-color: #434F72;
                  color: white;
               }
               .view-btn {
                  margin-left: 0rem;
               }
            </style>
               <tr>
            <th>
                ID
                <i class="fas fa-sort"></i>
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fas fa-sort-alpha-up"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Ascending</a>
                        <a class="dropdown-item" href="#">Descending</a>
                    </div>
                </div>
            </th>
            <th>
                Item Article
                <i class="fas fa-sort"></i>
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fas fa-sort-alpha-up"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Ascending</a>
                        <a class="dropdown-item" href="#">Descending</a>
                    </div>
                </div>
            </th>
            <th>
                School
                <i class="fas fa-sort"></i>
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fas fa-sort-alpha-up"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Ascending</a>
                        <a class="dropdown-item" href="#">Descending</a>
                    </div>
                </div>
            </th>
            <th>
                Status
                <i class="fas fa-sort"></i>
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fas fa-sort-alpha-up"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Ascending</a>
                        <a class="dropdown-item" href="#">Descending</a>
                    </div>
                </div>
            </th>
            <th>
                Date Acquired
                <i class="fas fa-sort"></i>
                <div class="dropdown">
                    <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fas fa-sort-alpha-up"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Ascending</a>
                        <a class="dropdown-item" href="#">Descending</a>
                    </div>
                </div>
            </th>
            <th>Actions</th>
        </tr>
            </thead>
            <tbody class="oveflow-y-scroll">
               <?php if (count($resources) > 0): ?>
                  <?php foreach ($resources as $resource): ?>
                     <tr>
                        <td><?= htmlspecialchars($resource['item_code']) ?></td>
                        <td><?= htmlspecialchars($resource['item_article']) ?></td>
                        <td><?= htmlspecialchars($resource['school_name'] ?? 'Unassigned') ?></td>
                        <td><?= htmlspecialchars($statusMap[$resource['status']]) ?></td>
                        <td><?= htmlspecialchars(formatTimestamp($resource['date_acquired'])) ?></td>
                        <td>
                           <div class="h-full w-full flex items-center gap-2">
                              <button class="view-btn">
                                 <i class="bi bi-eye-fill"></i>
                              </button>
                        </td>
                     </tr>
                  <?php endforeach; ?>
               <?php else: ?>
                  <tr>
                     <td colspan="6">
                        <div class="h-full w-full flex items-center gap-2">
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
                              href="/coordinator/resources?page=1"
                              class="pagination-link">
                              <i class="bi bi-chevron-bar-left"></i>
                           </a>
                           <a
                              href="/coordinator/resources?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>" class="pagination-link">
                              <i class="bi bi-chevron-left"></i>
                           </a>
                           <a href="/coordinator/resources?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>"
                              class="pagination-link">
                              <i class="bi bi-chevron-right"></i>
                           </a>
                           <a href="/coordinator/resources?page=<?= htmlspecialchars($pagination['pages_total']) ?>"
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
   const ratio_ctx = document.getElementById('ratio').getContext('2d');
   const ratio = new Chart(ratio_ctx, {
      type: 'pie',
      data: {
         labels: ['Working', 'Repair', 'Condemned'],
         datasets: [{
            data: [65, 20, 25],
            backgroundColor: [
               'rgba(22, 163, 72, 0.5)',
               'rgba(255, 159, 64, 0.5)',
               'rgba(255, 99, 132, 0.5)',
            ],
            borderColor: [
               'rgba(22, 163, 74, 1)',
               'rgba(255, 144, 32, 1)',
               'rgba(255, 64, 105, 1)',
            ],
            borderWidth: 1
         }]
      },
      options: {
         responsive: true,
         maintainAspectRatio: false,
         plugins: {
            title: {
               display: true,
               text: 'Inventory Status Ratio'
            }
         }
      }
   });
</script>

<script>
   const i_ratio_ctx = document.getElementById('i_ratio').getContext('2d');
   const i_ratio = new Chart(i_ratio_ctx, {
      type: 'doughnut',
      data: {
         labels: ['Mouse', 'Laptops', 'Keyboard', 'RAM Sticks', 'Desktop Sets', 'Monitors'],
         datasets: [{
            label: 'Inventory Item Ratio',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
         }]
      },
      options: {
         responsive: true,
         maintainAspectRatio: false,
         plugins: {
            title: {
               display: true,
               text: 'Inventory Item Ratio'
            }
         }
      }
   });
</script>

<?php require base_path('views/partials/footer.php') ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>