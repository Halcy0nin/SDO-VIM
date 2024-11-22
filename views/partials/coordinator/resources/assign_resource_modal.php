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
document.addEventListener('DOMContentLoaded', () => {
    // Add event listener for all modals
    document.querySelectorAll('.modal').forEach(modal => {
        const dropdown = modal.querySelector('.custom-dropdown');
        const selected = modal.querySelector('#dropdown-selected');
        const optionsContainer = modal.querySelector('.custom-dropdown-options');
        const options = modal.querySelectorAll('.custom-option');
        const hiddenInput = modal.querySelector('#school_id');

        if (dropdown) {
            // Toggle dropdown visibility when clicking on the selected area
            dropdown.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent event from bubbling
                dropdown.classList.toggle('active');
                optionsContainer.style.display = dropdown.classList.contains('active') ? 'block' : 'none';
            });

            // Handle option selection
            options.forEach(option => {
                option.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const value = option.getAttribute('data-value');
                    const text = option.textContent;

                    selected.textContent = text;
                    hiddenInput.value = value;





                    // Close dropdown
                    dropdown.classList.remove('active');
                    optionsContainer.style.display = 'none';
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', () => {
                dropdown.classList.remove('active');
                optionsContainer.style.display = 'none';
            });
        }
    });


    // Reapply dropdown functionality on modal show
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('shown.bs.modal', () => {
            const dropdown = modal.querySelector('.custom-dropdown');
            if (dropdown) {
                dropdown.classList.remove('active');
                const optionsContainer = dropdown.querySelector('.custom-dropdown-options');
                optionsContainer.style.display = 'none';
            }
        });
    });
});


</script>