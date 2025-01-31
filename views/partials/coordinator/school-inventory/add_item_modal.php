<!-- Modal Button -->

<button class="flex items-center w-fit shrink-0 px-3 py-2 rounded shadow-md bg-green-500 text-white gap-2 font-bold hover:bg-green-600" data-bs-toggle="modal" data-bs-target="#addItemModal">
    <i class="bi bi-plus-circle-fill"></i>
    <p>Add Item</p>
</button>

<!-- Modal -->

<main class="modal fade " id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/school-inventory" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-box-seam-fill"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addItemModalLabel">Add New Item</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-1/2">
                        <?php text_input('Item Article', 'item_article', 'Item Article', $old['item_article'] ?? '') ?>
                    </div>
                    <div class="w-1/2">
                        <?php text_input('Item Description', 'item_desc', 'Item Description', $old['item_desc'] ?? '') ?>
                    </div>
                </div>
                <?php if (isset($errors['add_item']['item_article'])): ?>
                    <p class="error"><?= $errors['add_item']['item_article'] ?></p>
                <?php endif; ?>
                <?php if (isset($errors['add_item']['item_desc'])): ?>
                    <p class="error"><?= $errors['add_item']['item_desc'] ?></p>
                <?php endif; ?>

                <div class="flex items-center gap-2">
                    <div class="w-1/2">
                        <?php text_input('Price', 'item_unit_value', 'Unit Price', $old['item_unit_value'] ?? '') ?>
                    </div>
                    <div class="w-1/2">
                        <?php text_input('Qty.', 'item_quantity', 'Quantity', $old['item_quantity'] ?? '') ?>
                    </div>
                </div>
                <?php if (isset($errors['add_item']['item_unit_value'])): ?>
                    <p class="error"><?= $errors['add_item']['item_unit_value'] ?></p>
                <?php endif; ?>
                <?php if (isset($errors['add_item']['item_quantity'])): ?>
                    <p class="error"><?= $errors['add_item']['item_quantity'] ?></p>
                <?php endif; ?>

                <div class="flex items-center gap-2">
                    <div class="w-1/2">
                        <?php text_input('Active Items', 'item_active', 'No. Of Active Items', $old['item_active'] ?? '') ?>
                    </div>
                    <div class="w-1/2">
                        <?php text_input('Inactive Items', 'item_inactive', 'No. Of Inactive Items', $old['item_inactive'] ?? 0) ?>
                    </div>
                </div>
                <?php if (isset($errors['add_item']['item_active'])): ?>
                    <p class="error"><?= $errors['add_item']['item_active'] ?></p>
                <?php endif; ?>
                <?php if (isset($errors['add_item']['item_inactive'])): ?>
                    <p class="error"><?= $errors['add_item']['item_inactive'] ?></p>
                <?php endif; ?>

                <div class="my-1">
                    <p class="text-xs text-zinc-500 ml-2 mb-1">Date Acquired</p>
                    <input type="date" name="date_acquired" value="$old['date_acquired']" class=" text-[#434F72]" />
                </div>
                <div class="my-1">
                    <p class="text-xs text-zinc-500 ml-2 mb-1">Warranty End Date</p>
                    <input type="date" name="warranty_end" class=" text-[#434F72]" />
                </div>
                <div>
                    <?php text_input('Source of Funds', 'item_funds_source', 'Source Of Funds', $old['item_funds_source'] ?? '') ?>
                </div>
                <?php if (isset($errors['add_item']['item_funds_source'])): ?>
                    <p class="error"><?= $errors['add_item']['item_funds_source'] ?></p>
                <?php endif; ?>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (<?php echo json_encode(array_key_exists('add_item', $errors) && count($errors['add_item']) > 0) ?>) {
                            var addItemModal = new bootstrap.Modal(document.getElementById('addItemModal'));
                            addItemModal.show();
                        }
                    });
                </script>

                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Add Item</button>
                </div>
            </form>
        </div>
    </div>
</main>