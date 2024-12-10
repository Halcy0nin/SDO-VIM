<!-- Modal Button -->

<div class="parent-container">
    <button class="move-button" data-bs-toggle="modal" data-bs-target="#assignResourceModal">
        <i class="bi bi-stack"></i>
        <p>Assign Resources</p>
    </button>
</div>

<!-- Modal -->
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

<script>


</script>