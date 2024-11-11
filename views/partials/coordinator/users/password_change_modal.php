<!-- Modal Button -->

<button class="view-btn" data-bs-toggle="modal" data-bs-target="#changePassword<?php echo $user['user_id']; ?>">
    <i class="bi bi-key-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="changePassword<?php echo $user['user_id']; ?>" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/users/changePassword" method="POST" class="modal-body h-fit flex flex-col gap-2">
            <input name="_method" value="PATCH" hidden />
            <input name="id_to_update" value = "<?php echo $user["user_id"]; ?>" hidden />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-blue-600 text-xl">
                        <i class="bi bi-key-fill"></i>
                        <h1 class="modal-title fs-5 font-bold" id="changePasswordModalLabel">Change <?= $user['user_name'] ?? 'User' ?>'s password</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                    <?php text_input('Password', 'password', 'password', '', 'password') ?>
                </div>
                <div>
                    <?php text_input('Confirm Password', 'confirm_password', 'confirm password', '', 'password') ?>
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-blue-500 hover:bg-blue-400">Change Password</button>
                </div>
            </form>

        </div>
    </div>
</main>