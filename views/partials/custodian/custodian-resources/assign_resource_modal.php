<!-- Modal Button -->

<button class="view-btn" data-bs-toggle="modal" data-bs-target="#assignResource<?php echo htmlspecialchars($resource['item_code']); ?>">
    <i class="bi bi-eye-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="assignResource<?php echo htmlspecialchars($resource['item_code']); ?>" tabindex="-1" aria-labelledby="assignResourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/custodian/custodian-resources/unassigned" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="_method" value="PATCH" hidden />
                <input type="hidden" name="item_code" value="<?php echo htmlspecialchars($resource['item_code']); ?>"/>
                <input type="hidden" name="school_id" value="<?php echo htmlspecialchars($_SESSION['user']['school_id']); ?>"/>
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-box-seam-fill sidebar-li-icon"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addItemModalLabel">Assign Resource: <?php echo htmlspecialchars($resource['item_article']); ?> </h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex items-center gap-2">
                    Are you sure you want to assign this item to your school?
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Assign</button>
                </div>
            </form>

        </div>
    </div>
</main>