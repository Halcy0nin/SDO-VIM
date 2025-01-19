<!-- Modal Button -->

<button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editItem<?php echo $item['item_code']; ?>">
    <i class="bi bi-pencil-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="editItem<?php echo $item['item_code']; ?>" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/custodian/custodian-inventory" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="_method" value="PATCH" hidden />
                <input name="id_to_update" value="<?php echo $item["item_code"]; ?>" hidden />
                <input type="hidden" name="school_id" value="<?php echo $item["school_id"];; ?>" />
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
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
                <div class="flex items-center gap-2">
                    <span>
                        <?php text_input('Price', 'item_unit_value', 'Unit Price', $item['item_unit_value'] ?? '') ?>
                    </span>
                    <span>
                        <?php text_input('Qty.', 'item_quantity', 'Quantity', $item['item_quantity'] ?? '') ?>
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span>
                        <?php text_input('Active Items', 'item_active', 'No. Of Active Items', $item['item_active'] ?? '') ?>
                    </span>
                    <span>
                        <?php text_input('Inactive Items', 'item_inactive', 'No. Of Inactive Items', $item['item_inactive'] ?? '') ?>
                    </span>
                </div>
                <div>
                    <p>Date Acquired</p>
                    <input type="date" name="date_acquired" value="<?php echo $item['date_acquired'] ?>" />
                </div>
                <div>
                    <p>Warranty End Date</p>
                    <input type="date" name="warranty_end" value="<?php echo $item['warranty_end'] ?>" />
                </div>
                <div>
                <div>
                    <?php text_input('Source of Funds', 'item_funds_source', 'Source Of Funds', $item['item_funds_source'] ?? '') ?>
                </div>
                <div>
                <?php
                    select_input(
                        'Item Status',
                        "item_status_{$item['item_code']}",
                        'item_status',
                        [
                            1 => 'Working',
                            2 => 'Need Repair',
                            3 => 'Condemned'
                        ],
                        $item['item_status'] ?? 1
                    );
                    ?>
                </div>

                <span id="status_reason_container_<?php echo $item['item_code']; ?>" style="display: none;">
                    <?php text_input('Reason', 'item_status_reason', 'Reason', $item['item_status_reason'] ?? '', 'text', false) ?>
                </span>

                <span id="repair_count_field_<?php echo $item['item_code']; ?>" style="display: none;">
                    <?php text_input('No. of items that need repair', 'item_repair_count', 'No. Of Items', 0) ?>
                </span>

                <span id="condemned_count_field_<?php echo $item['item_code']; ?>" style="display: none;">
                    <?php text_input('No. of items that are condemned', 'item_condemned_count', 'No. Of Items', 0) ?>
                </span>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Dynamically select each modal based on its unique id
                        const statusSelect = document.getElementById('item_status_<?php echo $item['item_code']; ?>');
                        const statusReasonContainer = document.getElementById('status_reason_container_<?php echo $item['item_code']; ?>');
                        const repairCountField = document.getElementById('repair_count_field_<?php echo $item['item_code']; ?>');
                        const condemnedCountField = document.getElementById('condemned_count_field_<?php echo $item['item_code']; ?>');

                        function updateStatusFields() {
                            if (statusSelect.value === '2') {
                                statusReasonContainer.style.display = 'block';
                                repairCountField.style.display = 'block';
                                condemnedCountField.style.display = 'none';
                            } else if (statusSelect.value === '3') {
                                statusReasonContainer.style.display = 'block';
                                condemnedCountField.style.display = 'block';
                                repairCountField.style.display = 'none';
                            } else {
                                statusReasonContainer.style.display = 'none';
                                repairCountField.style.display = 'none';
                                condemnedCountField.style.display = 'none';
                            }
                        }

                        updateStatusFields();

                        statusSelect.addEventListener('change', updateStatusFields);
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