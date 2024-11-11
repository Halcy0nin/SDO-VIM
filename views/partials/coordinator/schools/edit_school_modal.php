<!-- Modal Button -->

<button id="edit<?php echo $school['school_id'] ?>" class="edit-btn" data-bs-toggle="modal" data-bs-target="#editSchool<?php echo $school['school_id']; ?>">
    <i class="bi bi-pencil-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="editSchool<?php echo $school['school_id']; ?>" tabindex="-1" aria-labelledby="editSchoolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/schools" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="id_to_update" value="<?php echo $school["school_id"]; ?>" hidden />
                <input name="_method" value="PATCH" hidden />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-pencil-fill"></i>
                        <h1 class="modal-title fs-5 font-bold" id="editSchoolModalLabel">Edit <?= $school['school_name'] ?? 'School' ?></h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-[12ch]">
                        <?php text_input('School ID', 'school_id', 'School ID', $school['school_id'] ?? '') ?>
                    </span>
                    <span class="w-full">
                        <?php text_input('School Name', 'school_name', 'School Name', $school['school_name'] ?? '') ?>
                    </span>
                </div>
                <?php if (isset($errors[$school['school_id']]['school_name'])): ?>
                    <p class="error"><?= $errors[$school['school_id']]['school_name'] ?></p>
                <?php endif; ?>
                <p class="error"><?= $errors[$school['school_id']]['school_id'] ?? '' ?></p>
                <?php if (isset($errors[$school['school_id']]['school_id'])): ?>
                <?php endif; ?>
                <div class="flex items-center gap-2 p-0 mt-2">
                    <div class="w-fit">
                        <?php
                        radio_group(
                            'Type of School',
                            'school_type',
                            [
                                1 => 'Public',
                                2 => 'Private',
                            ],
                            $school['school_type'] ?? 1
                        );
                        ?>
                    </div>
                    <span class="w-full">
                        <?php
                        select_input(
                            'School Division',
                            'school_division',
                            'school_division',
                            [
                                1 => 'DCS Valenzuela',
                            ],
                            $school['school_division'] ?? 1
                        );
                        ?>
                    </span>
                </div>
                <?php if (isset($errors[$school['school_id']]['school_division'])): ?>
                    <p class="error"><?= $errors[$school['school_id']]['school_division'] ?></p>
                <?php endif; ?>
                <?php if (isset($errors[$school['school_id']]['school_type'])): ?>
                    <p class="error"><?= $errors[$school['school_id']]['school_type'] ?></p>
                <?php endif; ?>
                <div class="w-full mt-2">
                    <?php
                    select_input(
                        'School District',
                        'school_district',
                        'school_district',
                        [
                            1 => 'Congressional I',
                            2 => 'Congressional II',
                            3 => 'East District',
                            4 => 'South District',
                        ],
                        $school['school_district'] ?? 1
                    );
                    ?>
                    <?php if (isset($errors[$school['school_id']]['school_district'])): ?>
                        <p class="error"><?= $errors[$school['school_id']]['school_district'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="mt-2">
                    <?php text_input('School Contact', 'contact_name', 'Contact Name', $school['contact_name'] ?? '') ?>
                    <?php if (isset($errors[$school['school_id']]['contact_name'])): ?>
                        <p class="error"><?= $errors[$school['school_id']]['contact_name'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="w-[15ch]">
                        <?php text_input('Contact Number', 'contact_no', '09XX XXX XXXX', $school['contact_no'] ?? '') ?>
                    </span>
                    <span class="w-full">
                        <?php text_input('Contact Email', 'contact_email', 'contact@email.me', $school['contact_email'] ?? '') ?>
                    </span>
                </div>
                <?php if (isset($errors[$school['school_id']]['contact_no']) || isset($errors[$school['school_id']]['contact_email'])): ?>
                    <p class="error flex gap-2"><?= $errors[$school['school_id']]['contact_no'] ?> <?= $errors[$school['school_id']]['contact_email'] ?></p>
                <?php endif; ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (<?php echo json_encode(array_key_exists($school['school_id'], $errors) && count($errors[$school['school_id']]) > 0) ?>) {
                            var editSchoolModal = new bootstrap.Modal(document.getElementById('editSchool<?php echo $school['school_id']; ?>'));
                            editSchoolModal.show();
                        }
                    });
                </script>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</main>