<?php $page_styles = ['/css/banner.css'];
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/sidebar.php') ?>
<?php require base_path('views/components/dashboard-card.php') ?>

<!-- Your HTML code goes here -->
<main class="main-col">
   <section class="flex items-center pr-12 gap-3">
      <?php require base_path('views/partials/banner.php') ?>
      <div class="school-name-container1">
               <h2 class="school-name1"><?= $schoolName ?></h2>
               <h2 class="date1">
                  <?php echo "Data as of " . date("F Y"); ?>
               </h2>
      </div>  
      <!-- Hide add receipt temporarily -->
   </section>
   
   <section class="mx-6 px-12 flex gap-6">
      <?php dashboard_card('Total Equipments', $totalEquipment, 'bi-boxes', '#434f72', '#434f72', '#434f72'); ?>
      <?php dashboard_card('Working', $totalWorking, 'bi-patch-check-fill', '#27ae5f', '#27ae5f', '#27ae5f'); ?>
      <?php dashboard_card('For Repair', $totalRepair, 'bi-tools','#F1C40F', '#F1C40F', '#F1C40F'); ?>
      <?php dashboard_card('Condemned', $totalCondemned, 'bi-exclamation-diamond-fill','#E74C3C', '#E74C3C', '#E74C3C'); ?>
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

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

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
               text: 'Top 5 Equipment by Quantity'
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
   
   // Define a consistent color mapping for each status
   const statusColorMap = {
       'Working': {
           background: 'rgba(22, 163, 72, 0.5)', // Green
           border: 'rgba(22, 163, 74, 1)' // Dark Green
       },
       'Need Repair': {
           background: 'rgba(255, 159, 64, 0.5)', // Orange
           border: 'rgba(255, 144, 32, 1)' // Dark Orange
       },
       'Condemned': {
           background: 'rgba(255, 99, 132, 0.5)', // Red
           border: 'rgba(255, 64, 105, 1)' // Dark Red
       }
   };

   // Create arrays for background and border colors based on status labels
   const backgroundColors = statusLabels.map(label => statusColorMap[label]?.background || 'rgba(0, 0, 0, 0.5)');
   const borderColors = statusLabels.map(label => statusColorMap[label]?.border || 'rgba(0, 0, 0, 1)');

   const ratio_ctx = document.getElementById('ratio').getContext('2d');
   const ratio = new Chart(ratio_ctx, {
      type: 'pie',
      data: {
         labels: statusLabels,
         datasets: [{
            data: statusCounts,
            backgroundColor: backgroundColors,
            borderColor: borderColors,
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
            },
            datalabels: {
               anchor: 'center',
               align: 'center',
               formatter: (value, ctx) => {
                  const total = ctx.dataset.data.reduce((sum, val) => sum + val, 0);
                  const percentages = ctx.dataset.data.map(val => (val / total) * 100);
                  const rounded = percentages.map((p, i) => i === ctx.dataset.data.length - 1
                     ? Math.round(100 - percentages.slice(0, -1).reduce((a, b) => a + Math.round(b), 0))
                     : Math.round(p)
                  );
                  return `${rounded[ctx.dataIndex]}%`;
               },
               color: '#000',
               font: {
                  weight: 'bold',
                  size: 10
               }
            }
         }
      },
      plugins: [ChartDataLabels] 
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
         },
         datalabels: {
            anchor: 'center',
            align: 'center',
            formatter: (value, ctx) => {
               const total = ctx.dataset.data.reduce((sum, val) => sum + val, 0);
               const percentages = ctx.dataset.data.map(val => (val / total) * 100);
               const rounded = percentages.map((p, i) => i === ctx.dataset.data.length - 1
                  ? Math.round(100 - percentages.slice(0, -1).reduce((a, b) => a + Math.round(b), 0))
                  : Math.round(p)
               );
               return `${rounded[ctx.dataIndex]}%`;
            },
            color: '#000',
            font: {
               weight: 'bold',
               size: 10
            }
         }
      }
   },
   plugins: [ChartDataLabels] 
});
</script>

<?php require base_path('views/partials/footer.php') ?>

<script>  
   const dropdowns = document.querySelectorAll('.dropdown1');

dropdowns.forEach(dropdown1 => {
  const select = dropdown1.querySelector('.select');
  const caret = dropdown1.querySelector('.caret');
  const menu = dropdown1.querySelector('.menu');
  const options = dropdown1.querySelectorAll('.menu li'); // Fixed query to select all <li>
  const selected = dropdown1.querySelector('.selected');

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
  dropdowns.forEach(dropdown1 => {
    if (!dropdown1.contains(e.target)) {
      const select = dropdown1.querySelector('.select');
      const caret = dropdown1.querySelector('.caret');
      const menu = dropdown1.querySelector('.menu');

      // Ensure dropdown is closed if clicked outside
      select.classList.remove('select-clicked');
      caret.classList.remove('caret-rotate');
      menu.classList.remove('menu-open');
    }
  });
});
</script> 