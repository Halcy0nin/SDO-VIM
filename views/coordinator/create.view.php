<?php $page_styles = ['/css/banner.css'];
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/sidebar.php') ?>
<?php require base_path('views/components/dashboard-card.php') ?>


<!-- Your HTML code goes here -->

<main class="main-col">
   <section>
      <?php require base_path('views/partials/banner.php') ?> 
      <?php require base_path('views/partials/coordinator/dashboard_searchbar.php') ?> 
   </section>

   <div class="school-name-container">
  <div class="right-group">
    <h2 class="school-name"><?= $schoolName ?? "All School" ?></h2>
    <h2 class="date">
      <?php 
         if ($startDate && $endDate) {
               echo "Data from " . date("F j, Y", strtotime($startDate)) . " to " . date("F j, Y", strtotime($endDate));
         } elseif (!$startDate && $endDate) {
               echo "Data up to " . date("F j, Y", strtotime($endDate));
         } else {
               echo "Data as of " . date("F Y");
         }
      ?>
   </h2>
  </div>
</div>    

      <div class="dropdown1">
         <div class="select">
            <span class="selected">Schools</span>
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
          

      <div class="date-filter-container6">
         <h1 style="font-weight: bold; color: #434F72">Inventory Date</h1>
         <input value="<?= htmlspecialchars($startDate) ?>" type="date" id="start-date" name="startDate" />

         <label for="end-date">to</label>
         <input value="<?= htmlspecialchars($endDate) ?>" type="date" id="end-date" name="endDate" />

         <button type="submit" class="filter-button" id="filter-btn">Filter</button>
         <button name="clearFilter" type="submit" class="filter-button" id="filter-btn">Clear Filter</button>
      </form>
      </div>

   <section class="mx-6 px-12 flex gap-6">
      <?php dashboard_card('Total Equipments', $totalEquipment); ?>
      <?php dashboard_card('Working', $totalWorking, 'bi-patch-check-fill'); ?>
      <?php dashboard_card('For Repair', $totalRepair, 'bi-tools'); ?>
      <?php dashboard_card('Condemned', $totalCondemned, 'bi-exclamation-diamond-fill'); ?>
   </section>
   <section class="grow mx-12 px-6 py-6 flex flex-col gap-6 text-red-500">
      <div class="flex items-center gap-6 h-1/2">
         <div class="h-full bg-zinc-50 border-[1px] rounded-lg p-3 flex-1"><canvas id="article"></canvas></div>
         <div class="h-full bg-zinc-50 border-[1px] rounded-lg p-3 shrink-0 w-1/4"><canvas id="ratio"></canvas></div>
      </div>
      <div class="flex items-center gap-6 h-1/2">
         <div class="h-full bg-zinc-50 border-[1px] rounded-lg p-3 shrink-0 w-1/3"><canvas id="i_ratio"></canvas></div>
         <div class="h-full bg-zinc-50 border-[1px] rounded-lg p-3 flex-1"><canvas id="inventory"></canvas></div>
      </div>
   </section>
</main>

<!-- bar chart -->
<script>
   const ctx = document.getElementById('myChart').getContext('2d');
   const myChart = new Chart(ctx, {
      type: 'bar',
      data: {
         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
         datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
               'rgba(255, 99, 132, 0.2)',
               'rgba(54, 162, 235, 0.2)',
               'rgba(255, 206, 86, 0.2)',
               'rgba(75, 192, 192, 0.2)',
               'rgba(153, 102, 255, 0.2)',
               'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
               'rgba(255, 99, 132, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(255, 206, 86, 1)',
               'rgba(75, 192, 192, 1)',
               'rgba(153, 102, 255, 1)',
               'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
         }]
      },
      options: {
         scales: {
            y: {
               beginAtZero: true
            }
         }
      }
   });
</script>

<script>
   const articleNames = JSON.parse('<?php echo $articleNames; ?>');
   const articleCounts = JSON.parse('<?php echo $articleCounts; ?>');
   const article_ctx = document.getElementById('article').getContext('2d');
   const article = new Chart(article_ctx, {
      type: 'bar',
      data: {
         labels: articleNames,
         datasets: [{
            label: '# of Equipments',
            data: articleCounts,
            backgroundColor: [
               'rgba(54, 162, 235, 0.2)',
            ],
            borderColor: [
               'rgba(54, 162, 235, 1)',
            ],
            borderWidth: 1
         }]
      },
      options: {
         responsive: true,
         maintainAspectRatio: false,
         scales: {
            y: {
               beginAtZero: true
            }
         },
         plugins: {
            title: {
               display: true,
               text: 'No. of Equipments per Article'
            }
         }
      }
   });
</script>

<script>
   const months = JSON.parse('<?php echo $months; ?>');
   const itemCountsPerMonth = JSON.parse('<?php echo $itemCountsPerMonth; ?>');
   const inventory_ctx = document.getElementById('inventory').getContext('2d');
   const inventory = new Chart(inventory_ctx, {
      type: 'line', 
      data: {
         labels: months, 
         datasets: [{
            label: 'Inventory Received per Month', 
            data: itemCountsPerMonth, 
            backgroundColor: 'rgba(54, 162, 235, 0.2)', 
            borderColor: 'rgba(54, 162, 235, 1)', 
            borderWidth: 2, 
            fill: false, 
            tension: 0.1 
         }]
      },
      options: {
         responsive: true,
         maintainAspectRatio: false,
         scales: {
            y: {
               beginAtZero: true, 
               title: {
                  display: true,
                  text: 'Number of Items Received' 
               }
            },
            x: {
               title: {
                  display: true,
                  text: 'Month' 
               }
            }
         },
         plugins: {
            title: {
               display: true,
               text: 'Monthly Inventory Stock Status' 
            }
         }
      }
   });
</script>


<script>
   const statusLabels = JSON.parse('<?php echo $statusLabels; ?>');
   const statusCounts = JSON.parse('<?php echo $statusCounts; ?>');
   const ratio_ctx = document.getElementById('ratio').getContext('2d');
   const ratio = new Chart(ratio_ctx, {
      type: 'pie',
      data: {
         labels: statusLabels,
         datasets: [{
            data: statusCounts,
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
         labels: articleNames,
         datasets: [{
            label: 'Inventory Item Ratio',
            data: articleCounts,
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

<script>  
// Select both dropdown1 and dropdown-date
const dropdowns = document.querySelectorAll('.dropdown1, .dropdown-date');

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
    document.querySelectorAll('.menu li').forEach(function(item) {
        item.addEventListener('click', function() {
            const selectedValue = this.getAttribute('data-value'); // Get the value from the clicked <li>
            document.getElementById('schoolFilterValue').value = selectedValue; // Set the hidden input value
            document.getElementById('schoolFilterForm').submit(); // Submit the form
        });
    });
</script>




