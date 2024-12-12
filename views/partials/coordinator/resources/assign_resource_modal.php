<!-- Modal Button -->

<button class="view-btn" data-bs-toggle="modal"
    data-bs-target="#assignResource<?php echo htmlspecialchars($resource['item_code']); ?>">
    <i class="bi bi-eye-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="assignResource<?php echo htmlspecialchars($resource['item_code']); ?>" tabindex="-1"
    aria-labelledby="assignResourceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/resources/unassigned" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="_method" value="PATCH" hidden />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-box-seam-fill sidebar-li-icon"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addItemModalLabel">Assign Resources</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="dropdown-resource">
                    <!-- Dropdown Button -->
                    <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Select School
                    </button>

                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php foreach ($schoolDropdownContent as $school): ?>
                            <li>
                                <a class="dropdown-items" href="#"
                                    data-value="<?= htmlspecialchars($school['school_id']); ?>">
                                    <?= htmlspecialchars($school['school_name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Hidden Input for School ID -->
                    <input type="hidden" name="school_id" id="school_id">
                </div>


                <div id="selectedItemsContainer"></div>
                <div class="modal-footer mt-4">
                    <button type="button"
                        class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit"
                        class="btn font-bold text-white bg-green-500 hover:bg-green-400">Assign</button>
                </div>
            </form>
        </div>
    </div>
</main>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the dropdown menu and the button
        const dropdownMenu = document.querySelector('.dropdown-menu');
        const dropdownButton = document.getElementById('dropdownMenuButton');
        const hiddenInput = document.getElementById('school_id');

        // Ensure the dropdown menu exists
        if (!dropdownMenu || !dropdownButton || !hiddenInput) {
            console.error('Dropdown elements are not found.');
            return;
        }

        // Use event delegation to handle clicks on the dropdown items
        dropdownMenu.addEventListener('click', function (event) {
            // Check if the clicked element is a dropdown item
            if (event.target && event.target.classList.contains('dropdown-items')) {
                const schoolName = event.target.innerText;
                const schoolId = event.target.getAttribute('data-value');

                // Debugging: Log the selected name and ID
                console.log('Selected school name:', schoolName);
                console.log('Selected school ID:', schoolId);

                // Update the button with the selected school name
                dropdownButton.innerText = schoolName;

                // Update the hidden input with the selected school ID
                hiddenInput.value = schoolId;
            }
        });
    });
</script>


