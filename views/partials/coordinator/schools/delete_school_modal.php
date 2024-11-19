<!-- Modal Button -->

<button class="del-btn" data-bs-toggle="modal" data-bs-target="#deleteSchool<?php echo $school['school_id']; ?>">
    <i class="bi bi-trash-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="deleteSchool<?php echo $school['school_id']; ?>" tabindex="-1" aria-labelledby="deleteSchoolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/schools" method="POST" class="modal-body h-fit flex flex-col gap-2">
            <input type="hidden" name="_method" value="DELETE" />
            <input name="id_to_delete" value = "<?php echo $school["school_id"]; ?>" hidden />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-red-600 text-xl">
                        <i class="bi bi-trash-fill"></i>
                        <h1 class="modal-title fs-5 font-bold" id="deleteSchoolModalLabel">Archive <?= $school['school_name'] ?? 'School' ?></h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="text-lg">
                        Are you sure you want to archive <span class="font-bold text-[#434F72]"><?php echo $school['school_name'] ?></span>?
                    </h3>
                    <p>This action cannot be undone.</p>
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-red-500 hover:bg-red-400">Archive School</button>
                </div>
            </form>
        </div>
    </div>
</main>