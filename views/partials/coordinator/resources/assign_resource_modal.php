<!-- Modal Button -->

<button class="view-btn" data-bs-toggle="modal" data-bs-target="#assignResource<?php echo htmlspecialchars($resource['item_code']); ?>">
    <i class="bi bi-eye-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="assignResource<?php echo htmlspecialchars($resource['item_code']); ?>" tabindex="-1" aria-labelledby="assignResourceModalLabel" aria-hidden="true">
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
// Get dropdown elements
const dropdown = document.querySelector('.custom-dropdown');
const selected = document.getElementById('dropdown-selected');
const optionsContainer = document.querySelector('.custom-dropdown-options');
const options = document.querySelectorAll('.custom-option');
const hiddenInput = document.getElementById('school_id');

// Toggle dropdown visibility when clicking on the dropdown
dropdown.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent clicks from bubbling up
    const isVisible = optionsContainer.style.display === 'block';
    optionsContainer.style.display = isVisible ? 'none' : 'block';

});

// Select an option from the dropdown
options.forEach(option => {
    option.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent clicks from bubbling up
        const value = option.getAttribute('data-value');
        const text = option.textContent;

        // Update selected display and hidden input value
        selected.textContent = text;
        hiddenInput.value = value;

        // Close the dropdown

        optionsContainer.style.display = 'none';
    });
});

// Close dropdown if clicking outside of it
document.addEventListener('click', () => {

    optionsContainer.style.display = 'none';
});

</script>