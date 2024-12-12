<div class="parent-container">
    <button class="move-button" data-bs-toggle="modal" data-bs-target="#assignResourceModal">
        <i class="bi bi-stack"></i>
        <p>Assign Resources</p>
    </button>
</div>

<!-- Modal for Multi-resource Assignment -->
<main class="modal fade" id="assignResourceModal" tabindex="-1" aria-labelledby="assignResourceModalLabel"
    aria-hidden="true">
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
                    <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Select School
                    </button>
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
    // Handle the selection
    document.querySelectorAll('.dropdown-items').forEach(item => {
        item.addEventListener('click', function () {
            // Set the selected school name in the button
            const schoolName = this.innerText;
            document.getElementById('dropdownMenuButton').innerText = schoolName;

            // Set the selected school ID in the hidden input
            const schoolId = this.getAttribute('data-value');
            document.getElementById('school_id').value = schoolId;
        });
    });
</script>