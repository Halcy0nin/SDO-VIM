<!-- Modal Button -->

<button class="flex items-center w-fit shrink-0 px-3 py-2 rounded shadow-md bg-green-500 text-white gap-2 font-bold hover:bg-green-600" data-bs-toggle="modal" data-bs-target="#addReceiptModal">
    <i class="bi bi-receipt"></i>
    <p>Add New Receipt</p>
</button>

<!-- Modal -->

<main class="modal fade " id="addReceiptModal" tabindex="-1" aria-labelledby="addReceiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/custodian/receipt" method="POST" class="modal-body h-fit flex flex-col gap-2" enctype="multipart/form-data">
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-receipt"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addReceiptModalLabel">Add New Receipt</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="text" name="id" id="id" value="<?php echo htmlspecialchars(get_uid()) ?>" hidden />
                <input class="block file:px-2 file:py-1 text-zinc-500 border border-gray-300 rounded-lg cursor-pointer bg-zinc-50 focus:outline-none file:text-zinc-100 file:border-0 file:bg-[#434F72] file:text-foreground" name="receipt" id="receipt" type="file" accept="image/jpg, image/png, image/jpeg">
                <?php if (isset($errors['add_receipt']['receipt'])): ?>
                    <p class="error"><?= $errors['add_receipt']['receipt'] ?></p>
                <?php endif; ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (<?php echo json_encode(isset($errors['add_receipt']) &&  count($errors['add_receipt']) > 0); ?>) {
                            var addReceiptModal = new bootstrap.Modal(document.getElementById('addReceiptModal'));
                            addReceiptModal.show();
                        }
                    });
                </script>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Add New Receipt</button>
                </div>
            </form>
        </div>
    </div>
</main>