<!-- Modal Button -->

<button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editUser<?php echo $user['user_id']; ?>">
    <i class="bi bi-pencil-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="editUser<?php echo $user['user_id']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/users" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="_method" value="PATCH" hidden />
                <input name="id_to_update" value="<?php echo $user["user_id"]; ?>" hidden />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-person-fill-add"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addUserModalLabel">Edit User <?= htmlspecialchars($user['user_name'] ?? 'User') ?></h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                    <?php text_input('Username', 'user_name', $user['user_name'], $user['user_name']) ?>
                    <?php if (isset($errors[$user['user_id']]['user_name'])): ?>
                        <p class="error"><?= $errors[$user['user_id']]['user_name'] ?></p>
                    <?php endif; ?>
                </div>
                <?php if ($user['user_role'] === 2) : ?>
                    <?php text_input('School ID', 'school_id', '123456', $user['school_id'] ?? '') ?>
                    <?php if (isset($errors[$user['user_id']]['school_id'])): ?>
                        <p class="error"><?= $errors[$user['user_id']]['school_id'] ?></p>
                    <?php endif; ?>
                <?php endif; ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if ( <?php echo json_encode(isset($errors[$user['user_id']]) &&  count($errors[$user['user_id']]) > 0); ?> ) {
                            var editSchoolModal = new bootstrap.Modal(document.getElementById('editUser<?php echo $user['user_id']; ?>'));
                            editSchoolModal.show();
                        }
                    });
                </script>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</main>