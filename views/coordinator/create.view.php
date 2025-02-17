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
    <h2 class="school-name"><?= $schoolName ?? "All Schools" ?></h2>
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
            <input id="schoolFilterValue" name="schoolFilterValue" value="<?= htmlspecialchars($schoolName ?? 'All Schools') ?>" type="hidden" />
            
            <ul class="menu">
                  <li data-value="All Schools">All Schools</li> <!-- Default option to show all schools -->
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
    <?php dashboard_card('Total Equipments', $totalEquipment, 'bi-boxes', '#434f72', '#434f72', '#434f72'); ?>
    <?php dashboard_card('Working', $totalWorking, 'bi-patch-check-fill', '#27ae5f', '#27ae5f', '#27ae5f' ); ?>
    <?php dashboard_card('For Repair', $totalRepair, 'bi-tools', '#F1C40F', '#F1C40F', '#F1C40F'); ?>
    <?php dashboard_card('Condemned', $totalCondemned, 'bi-exclamation-diamond-fill', '#E74C3C', '#E74C3C', '#E74C3C'); ?>
   </section>
   <section class="grow mx-12 px-6 py-6 flex flex-col gap-6 text-red-500">
      <div class="flex items-center gap-6 h-1/2">
         <div class="h-full bg-zinc-50 border-[1px] rounded-lg p-3 flex-1"><canvas id="article"></canvas></div>
         <div class="h-full bg-zinc-50 border-[1px] rounded-lg p-3 shrink-0 w-1/4"><canvas id="ratio"></canvas></div>
      </div>
      <div class="flex items-center gap-6 h-1/2">
         <div class="h-full bg-zinc-50 border-[1px] rounded-lg p-3 shrink-0 w-1/3"><canvas id="i_ratio"></canvas></div>
         <div class="h-full bg-zinc-50 border-[1px] rounded-lg p-3 flex-1" style="max-width: 550px;"><canvas id="inventory"></canvas></div>
         <div class="h-full bg-zinc-50 border-[1px] rounded-lg p-3 flex-1" style="max-width: 550px;"> <h3 class="text-lg font-bold mb-2" style="color: black;">School Status</h3> 
         <canvas id="schoolStatusCanvas" width="500" height="300"></canvas>
         <!-- School Status Modal -->
            <div class="modal fade" id="schoolModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header" style="font-weight: bold;color: black;">
                     School Status Details
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body" style="color: black;">
                     <p><strong>School Name:</strong> <span id="modalSchoolName"></span></p>
                     <p><strong>Affected Percentage:</strong> <span id="modalAffectedPercentage"></span>%</p>
                     <p><strong>Broken/Condemned Items:</strong></p>
                     <ul id="modalItemList"></ul>
                     </div>
                     <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>
</div>
      </div>
   </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

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
               text: 'Top 5 Least Equipment by Quantity'
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

<script>
  const canvas = document.getElementById("schoolStatusCanvas");
  const schoolStatus = JSON.parse('<?php echo $schoolStatus; ?>');

  if (canvas) {
    const ctx = canvas.getContext("2d");

    if (ctx) {
      const rowHeight = 40;
      const startX = 10;
      const startY = 40;
      const columnOffsets = [0, 60, 290, 420];
      let rowAreas = []; // Store row positions for hover/click detection
      let hoveredRow = null; // Track hovered row

      function drawTable() {
        ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear canvas

        ctx.font = "bold 14px Arial";
        ctx.fillStyle = "#000";
        const headers = ["ID", "School Name", "Status"];
        
        headers.forEach((header, index) => {
          ctx.fillText(header, startX + columnOffsets[index], startY);
        });

        ctx.strokeStyle = "#ccc";
        ctx.beginPath();
        ctx.moveTo(startX, startY + 10);
        ctx.lineTo(canvas.width - startX, startY + 10);
        ctx.stroke();

        ctx.font = "12px Arial";
        rowAreas = []; // Reset row positions

        schoolStatus.forEach((school, i) => {
          const affectedPercentage = parseFloat(school.affected_percentage);
          const y = startY + (i + 1) * rowHeight;
          const rowTop = y - 15;
          const rowBottom = y + 15;

          rowAreas.push({ yStart: rowTop, yEnd: rowBottom, school });

          // If hovered, draw a gray background covering the entire row
          if (hoveredRow === i) {
            ctx.fillStyle = "#e0e0e0"; // Light gray
            ctx.fillRect(startX, rowTop - 15, canvas.width - startX * 2, rowHeight);
          }

          ctx.fillStyle = "#000";
          ctx.fillText(school.school_id, startX + columnOffsets[0], y);
          ctx.fillText(school.school_name, startX + columnOffsets[1], y);

          let status, statusColor;
          if (affectedPercentage > 50) {
            status = "Critical";
            statusColor = "#FF0000";
          } else if (affectedPercentage === 50) {
            status = "Warning";
            statusColor = "#FFA500";
          } else {
            status = "Normal";
            statusColor = "#000";
          }

          ctx.font = "bold 12px Arial";
          ctx.fillStyle = statusColor;
          ctx.fillText(status, startX + columnOffsets[2], y);
          ctx.font = "12px Arial";
          ctx.fillStyle = "#000";

          ctx.strokeStyle = "#ccc";
          ctx.beginPath();
          ctx.moveTo(startX, y + 10);
          ctx.lineTo(canvas.width - startX, y + 10);
          ctx.stroke();
        });
      }

      // Mouse move event for hover effect
      canvas.addEventListener("mousemove", function (event) {
      const rect = canvas.getBoundingClientRect();
      const mouseY = event.clientY - rect.top;

      let newHoveredRow = null;
      let isHovering = false;

  rowAreas.forEach((row, index) => {
    if (mouseY >= row.yStart && mouseY <= row.yEnd) {
      newHoveredRow = index;
      isHovering = true;
    }
  });

  if (newHoveredRow !== hoveredRow) {
    hoveredRow = newHoveredRow;
    drawTable(); // Redraw the table with hover effect
  }

  // Change cursor to pointer if hovering over a row, otherwise default
  canvas.style.cursor = isHovering ? "pointer" : "default";
});

      // Mouse leave event to remove highlight
      canvas.addEventListener("mouseleave", function () {
        hoveredRow = null;
        drawTable();
      });

      // Click event to open modal
      canvas.addEventListener("click", function (event) {
        const rect = canvas.getBoundingClientRect();
        const clickY = event.clientY - rect.top;

        rowAreas.forEach(row => {
          if (clickY >= row.yStart && clickY <= row.yEnd) {
            openModal(row.school);
          }
        });
      });

      function openModal(school) {
        document.getElementById("modalSchoolName").textContent = school.school_name;
        document.getElementById("modalAffectedPercentage").textContent = parseFloat(school.affected_percentage).toFixed(1);
        
        const itemList = document.getElementById("modalItemList");
        itemList.innerHTML = ""; // Clear previous items

        if (school.broken_condemned_items) {
          const items = school.broken_condemned_items.split(", ");
          items.forEach(item => {
            const li = document.createElement("li");
            li.textContent = item;
            itemList.appendChild(li);
          });
        } else {
          itemList.innerHTML = "<li>No broken items</li>";
        }

        const modal = new bootstrap.Modal(document.getElementById("schoolModal"));
        modal.show();
      }

      // Initial draw
      drawTable();
    }
  }
</script>

<form id="invisible-form" action="/inventory-check" method="POST" style="display: none;">
    <input type="hidden" name="action" value="send_inventory_email">
</form>

<script>
    const isSessionInitialized = <?php echo (session_status() == PHP_SESSION_ACTIVE) ? 'true' : 'false'; ?>;

    document.addEventListener('DOMContentLoaded', function () {
        if (isSessionInitialized) {
            console.log('Session is initialized.');

            // Prevent duplicate form submissions using sessionStorage
            if (!sessionStorage.getItem('email_sent')) {
                document.getElementById('invisible-form').submit();
                sessionStorage.setItem('email_sent', 'true'); // Mark as sent in sessionStorage
            } else {
                console.log('Email already sent in this session.');
            }
        } else {
            console.log('Session is not initialized.');
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




