
<div class="parent-container">
    <button class="move-button" data-bs-toggle="modal" data-bs-target="#assignResourceModal">
        <i class="bi bi-stack"></i>
        <p>Assign Resources</p>
    </button>
</div>

<!-- Modal for Multi-resource Assignment -->
<main class="modal fade" id="assignResourceModal" tabindex="-1" aria-labelledby="assignResourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/resources/unassigned" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="_method" value="PATCH" hidden />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-box-seam-fill sidebar-li-icon"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addItemModalLabel">Assign Resources</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="custom-dropdown">
                    <span id="dropdown-selected">Select School</span>
                    <div class="custom-dropdown-options">
                        <?php foreach ($schoolDropdownContent as $school): ?>
                            <div class="custom-option" data-value="<?= htmlspecialchars($school['school_id']); ?>">
                                <?= htmlspecialchars($school['school_name']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="school_id" id="school_id">
                </div>
                <div id="selectedItemsContainer"></div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Assign</button>
                </div>
            </form>
        </div>
    </div>
</main>


<!-- Modal for Single Resource Assignment -->
<main class="modal fade" id="assignResource<?php echo htmlspecialchars($resource['item_code']); ?>" tabindex="-1" aria-labelledby="assignResourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/resources/unassigned" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="_method" value="PATCH" hidden />
                <input type="hidden" name="item_code" value="<?php echo htmlspecialchars($resource['item_code']); ?>"/>
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-box-seam-fill sidebar-li-icon"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addItemModalLabel">Assign Resource: <?php echo htmlspecialchars($resource['item_article']); ?> </h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="custom-dropdown">
                    <span id="dropdown-selected">Select School</span>
                    <div class="custom-dropdown-options">
                        <?php foreach ($schoolDropdownContent as $school): ?>
                            <div class="custom-option" data-value="<?= htmlspecialchars($school['school_id']); ?>">
                                <?= htmlspecialchars($school['school_name']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="school_id" id="school_id">
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Assign</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>

document.addEventListener('DOMContentLoaded', () => {

// Function to initialize or re-initialize the dropdown behavior
function initializeDropdown(modal) {
    const dropdown = modal.querySelector('.custom-dropdown');
    const selected = modal.querySelector('#dropdown-selected');
    const optionsContainer = modal.querySelector('.custom-dropdown-options');
    const options = modal.querySelectorAll('.custom-option');
    const hiddenInput = modal.querySelector('#school_id');

    // Reset dropdown state when the modal is shown
    dropdown.classList.remove('active');
    optionsContainer.style.display = 'none';
    selected.textContent = 'Select School';  // Optionally reset the selected label to default

    // If there's only one option, set it as the default and hide the dropdown
    if (options.length === 1) {
        selected.textContent = options[0].textContent; // Select the only option
        hiddenInput.value = options[0].getAttribute('data-value');
        optionsContainer.style.display = 'none';  // Hide the dropdown
        dropdown.classList.remove('active');  // Remove active class to prevent interaction
    }

    // Toggle dropdown visibility when clicking on the selected area
    dropdown.addEventListener('click', toggleDropdown);

    // Update selected value and close dropdown when an option is clicked
    options.forEach(option => {
        option.addEventListener('click', selectOption);
    });

    // Close dropdown if clicking outside of it
    document.addEventListener('click', closeDropdownOutside);

    // Helper functions

    // Toggle dropdown open/close
    function toggleDropdown(e) {
        e.stopPropagation(); // Prevent click from bubbling up
        if (options.length > 1) {
            dropdown.classList.toggle('active');
            optionsContainer.style.display = dropdown.classList.contains('active') ? 'block' : 'none';
        }
    }

    // Select option and close dropdown
    function selectOption(e) {
        e.stopPropagation(); // Prevent click from bubbling up

        const value = e.target.getAttribute('data-value');
        const text = e.target.textContent;

        // Update the display text of the dropdown to show the selected option
        selected.textContent = text;
        hiddenInput.value = value;

        // Close the dropdown after selecting an option
        dropdown.classList.remove('active');
        optionsContainer.style.display = 'none';
    }

    // Close dropdown if clicking outside of it
    function closeDropdownOutside(e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
            optionsContainer.style.display = 'none';
        }
    }

    // Remove event listeners when modal is closed
    modal.addEventListener('hidden.bs.modal', () => {
        dropdown.removeEventListener('click', toggleDropdown);
        options.forEach(option => {
            option.removeEventListener('click', selectOption);
        });
        document.removeEventListener('click', closeDropdownOutside);
    });
}

// Attach event listeners to modals to initialize dropdown when modal is shown
const modals = document.querySelectorAll('.modal');
modals.forEach(modal => {
    modal.addEventListener('shown.bs.modal', function () {
        // Re-initialize the dropdown each time the modal is shown
        initializeDropdown(this);
    });
});

// Handle the eye icon to show the modal and trigger the dropdown
const eyeIcons = document.querySelectorAll('.view-btn');
eyeIcons.forEach(icon => {
    icon.addEventListener('click', (e) => {
        const targetModalId = e.target.closest('[data-bs-target]').getAttribute('data-bs-target');
        const modal = document.querySelector(targetModalId);

        // Wait until the modal is shown, then trigger the dropdown
        $(modal).on('shown.bs.modal', function () {
            // Automatically open the dropdown when the modal is shown
            const dropdown = modal.querySelector('.custom-dropdown');
            const optionsContainer = modal.querySelector('.custom-dropdown-options');
            if (dropdown && optionsContainer) {
                dropdown.classList.add('active');
                optionsContainer.style.display = 'block';
            }
        });
    });
});

});


</script>