<!-- Modal Button -->

<button class="del-btn" data-bs-toggle="modal" data-bs-target="#denyRequest<?php echo $request['id'] ?? ''; ?>">
    <i class="bi bi-x-circle-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="denyRequest<?php echo $request['id'] ?? ''; ?>" tabindex="-1" aria-labelledby="denyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/users/deny" method="POST" class="modal-body h-fit flex flex-col gap-2">
            <input name="_method" value="PATCH" hidden />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-red-600 text-xl">
                        <i class="bi bi-x-circle-fill"></i>
                        <h1 class="modal-title fs-5 font-bold" id="denyModalLabel">Deny <?= $request['user_name'] ?? 'User' ?>'s Request</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex flex-col gap-2">
                    <h3 class="text-lg">
                        Are you sure you want to deny <span class="font-bold text-[#434F72]"><?php echo $request['user_name'] ?? 'requester' ?></span>'s request?
                    </h3>
                    <p class="text-[#434F72] mb-2">New Username:<?php echo $request['new_username'] ?? 'Request Description' ?></p>
                    <input type="hidden" name="id_to_update" value="<?php echo $request['user_id']; ?> "/>                
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-red-500 hover:bg-red-400">Deny Request</button>
                </div>
            </form>
        </div>
    </div>
</main>