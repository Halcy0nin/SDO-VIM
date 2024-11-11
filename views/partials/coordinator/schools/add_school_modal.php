<!-- Modal Button -->

<button class="flex items-center w-fit shrink-0 px-3 py-2 rounded shadow-md bg-green-500 text-white gap-2 font-bold hover:bg-green-600" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
    <i class="bi bi-building-fill-add"></i>
    <p>Add new School</p>
</button>

<!-- Modal -->

<main class="modal fade " id="addSchoolModal" tabindex="-1" aria-labelledby="addSchoolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/schools" method="POST" class="modal-body h-fit flex flex-col">
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-building-fill-add"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addSchoolModalLabel">Add New School</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-[12ch]">
                        <?php text_input('School ID', 'school_id', 'School ID', $old['school_id'] ?? '') ?>
                    </span>
                    <span class="w-full">
                        <?php text_input('School Name', 'school_name', 'School Name', $old['school_name'] ?? '') ?>
                    </span>
                </div>
                <?php if (isset($errors['add_school']['school_name'])): ?>
                    <p class="error"><?= $errors['add_school']['school_name'] ?></p>
                <?php endif; ?>
                <?php if (isset($errors['add_school']['school_id'])): ?>
                    <p class="error"><?= $errors['add_school']['school_id'] ?></p>
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
                            $old['school_type'] ?? 1
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
                            $old['school_division'] ?? 1
                        );
                        ?>
                    </span>
                </div>
                <?php if (isset($errors['add_school']['school_division'])): ?>
                    <p class="error"><?= $errors['add_school']['school_division'] ?></p>
                <?php endif; ?>
                <?php if (isset($errors['add_school']['school_type'])): ?>
                    <p class="error"><?= $errors['add_school']['school_type'] ?></p>
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
                        $old['school_district'] ?? 1
                    );
                    ?>
                    <?php if (isset($errors['add_school']['school_district'])): ?>
                        <p class="error"><?= $errors['add_school']['school_district'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="mt-2">
                    <?php text_input('School Contact', 'contact_name', 'Contact Name', $old['contact_name'] ?? '') ?>
                    <?php if (isset($errors['add_school']['contact_name'])): ?>
                        <p class="error"><?= $errors['add_school']['contact_name'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="w-[15ch]">
                        <?php text_input('Contact Number', 'contact_no', '09XX XXX XXXX', $old['contact_no'] ?? '') ?>
                    </span>
                    <span class="w-full">
                        <?php text_input('Contact Email', 'contact_email', 'contact@email.me', $old['contact_email'] ?? '') ?>
                    </span>
                </div>
                <?php if (isset($errors['add_school']['contact_no']) || isset($errors['add_school']['contact_email'])): ?>
                    <p class="error flex gap-2"><?= $errors['add_school']['contact_no'] ?> <?= $errors['add_school']['contact_no'] ?></p>
                <?php endif; ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (<?php echo json_encode(array_key_exists('add_school', $errors) && count($errors['add_school']) > 0) ?>) {
                            var addSchoolModal = new bootstrap.Modal(document.getElementById('addSchoolModal'));
                            addSchoolModal.show();
                        }
                    });
                </script>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Add New School</button>
                </div>
            </form>
        </div>
    </div>
</main>