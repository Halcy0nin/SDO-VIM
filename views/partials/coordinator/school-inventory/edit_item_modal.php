<!-- Modal Button -->

<button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editItem<?php echo $item['item_code']; ?>">
    <i class="bi bi-pencil-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="editItem<?php echo $item['item_code']; ?>" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/school-inventory" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="_method" value="PATCH" hidden />
                <input name="id_to_update" value="<?php echo $item["item_code"]; ?>" hidden />
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-person-fill-add"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addItemModalLabel">Edit Item: <?= htmlspecialchars($item['item_article'] ?? 'item') ?></h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex items-center gap-2">
                    <span>
                        <?php text_input('Item Article', 'item_article', 'Item Article', $item['item_article'] ?? '') ?>
                    </span>
                    <span>
                        <?php text_input('Item Description', 'item_desc', 'Item Description', $item['item_desc'] ?? '') ?>
                    </span>
                </div>
                <?php if (isset($errors[$item['item_code']]['item_article'])): ?>
                    <p class="error"><?= $errors[$item['item_code']]['item_article'] ?></p>
                <?php endif; ?>
                <p class="error"><?= $errors[$item['item_code']]['item_desc'] ?? '' ?></p>
                <?php if (isset($errors[$item['item_code']]['item_desc'])): ?>
                <?php endif; ?>

                <div class="flex items-center gap-2">
                    <span>
                        <?php text_input('Price', 'item_unit_value', 'Unit Price', $item['item_unit_value'] ?? '') ?>
                    </span>
                    <span>
                        <?php text_input('Qty.', 'item_quantity', 'Quantity', $item['item_quantity'] ?? '') ?>
                    </span>
                </div>
                <?php if (isset($errors[$item['item_code']]['item_unit_value'])): ?>
                    <p class="error"><?= $errors[$item['item_code']]['item_unit_value'] ?></p>
                <?php endif; ?>
                <?php if (isset($errors[$item['item_code']]['item_quantity'])): ?>
                    <p class="error"><?= $errors[$item['item_code']]['item_quantity'] ?></p>
                <?php endif; ?>

                <div class="flex items-center gap-2">
                    <span>
                        <?php text_input('Active Items', 'item_active', 'No. Of Active Items', $item['item_active'] ?? '') ?>
                    </span>
                    <span>
                        <?php text_input('Inactive Items', 'item_inactive', 'No. Of Inactive Items', $item['item_inactive'] ?? '') ?>
                    </span>
                </div>
                <?php if (isset($errors[$item['item_code']]['item_active'])): ?>
                    <p class="error"><?= $errors[$item['item_code']]['item_active'] ?></p>
                <?php endif; ?>
                <?php if (isset($errors[$item['item_code']]['item_inactive'])): ?>
                    <p class="error"><?= $errors[$item['item_code']]['item_inactive'] ?></p>
                <?php endif; ?>

                <div>
                    <input type="date" name="date_acquired" value="<?php echo $item['date_acquired'] ?>" />
                </div>
                <div>
                    <?php text_input('Source of Funds', 'item_funds_source', 'Source Of Funds', $item['item_funds_source'] ?? '') ?>
                </div>
                <?php if (isset($errors[$item['item_code']]['item_funds_source'])): ?>
                    <p class="error"><?= $errors[$item['item_code']]['item_funds_source'] ?></p>
                <?php endif; ?>

                <div>
                    <?php
                    select_input(
                        'Item Status',
                        'item_status',
                        'item_status',
                        [
                            1 => 'Working',
                            2 => 'Need Repair',
                            3 => 'Condemned'
                        ],
                        $old['item_status'] ?? 1
                    );
                    ?>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (<?php echo json_encode(array_key_exists($item['item_code'], $errors) && count($errors[$item['item_code']]) > 0) ?>) {
                            var editItem = new bootstrap.Modal(document.getElementById('editItem<?php echo $item['item_code']; ?>'));
                            editItem.show();
                        }
                    });
                </script>

                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Edit Item</button>
                </div>
            </form>

        </div>
    </div>
</main>