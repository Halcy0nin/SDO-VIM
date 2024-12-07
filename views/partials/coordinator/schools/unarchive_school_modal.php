<!-- Modal Button -->

<button class="view-btn" data-bs-toggle="modal" data-bs-target="#unarchiveSchoolModal<?php echo $school['school_id']; ?>">
    <i class="bi bi-box-arrow-up"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="unarchiveSchoolModal<?php echo $school['school_id']; ?>" tabindex="-1" aria-labelledby="unarchiveSchoolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/schools/archived" method="POST" class="modal-body h-fit flex flex-col gap-2">
            <input type="hidden" name="_method" value="PATCH" />
            <input name="school_id" value = "<?php echo $school["school_id"]; ?>" hidden />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-blue-600 text-xl">
                        <i class="bi bi-trash-fill"></i>
                        <h1 class="modal-title fs-5 font-bold" id="unarchiveSchoolModalLabel">Unarchive <?= $school['school_name'] ?? 'School' ?></h1>
                    </div>
                    <button type="button" class="btn-close hover:text-blue-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="text-lg">
                        Are you sure you want to unarchive <span class="font-bold text-[#434F72]"><?php echo $school['school_name'] ?></span>?
                    </h3>
                    <p>This action cannot be undone.</p>
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-blue-500 hover:bg-blue-400">Unarchive School</button>
                </div>
            </form>
        </div>
    </div>
</main>