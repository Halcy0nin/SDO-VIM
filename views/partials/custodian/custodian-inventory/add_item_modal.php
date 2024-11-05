<!-- Modal Button -->

<button class="flex items-center w-fit shrink-0 px-3 py-2 rounded shadow-md bg-green-500 text-white gap-2 font-bold hover:bg-green-600" data-bs-toggle="modal" data-bs-target="#addItemModal">
    <i class="bi bi-plus-circle-fill"></i>
    <p>Add Item</p>
</button>

<!-- Modal -->

<main class="modal fade " id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/custodian/custodian-inventory" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-box-seam-fill"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addItemModalLabel">Add New Item</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex items-center gap-2">
                    <span>
                        <?php text_input('Item Article', 'item_article', 'Item Article', $old['item_article'] ?? '') ?>
                    </span>
                    <span>
                        <?php text_input('Item Description', 'item_desc', 'Item Description', $old['item_desc'] ?? '') ?>
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span>
                        <?php text_input('Price', 'item_unit_value', 'Unit Price', $old['item_unit_value'] ?? '') ?>
                    </span>
                    <span>
                        <?php text_input('Qty.', 'item_quantity', 'Quantity', $old['item_quantity'] ?? '') ?>
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span>
                        <?php text_input('Active Items', 'item_active', 'No. Of Active Items', $old['item_active'] ?? '') ?>
                    </span>
                    <span>
                        <?php text_input('Inactive Items', 'item_inactive', 'No. Of Inactive Items', $old['item_inactive'] ?? '') ?>
                    </span>
                </div>
                <div class="my-1 flex flex-col">
                    <label class="ml-2 text-xs text-zinc-500 mb-1">Date Acquired</label>
                    <input required type="date" name="date_acquired" value="$old['date_acquired']" class="w-fit p-2 outline-none rounded border-1 border-zinc-300 hover:border-zinc-400 active:border-[#434F72] focus:border-[#434F72] valid:border-[#434F72] shadow-inner" />
                </div>
                <div>
                    <?php text_input('Source of Funds', 'item_funds_source', 'Source Of Funds', $old['item_funds_source'] ?? '') ?>
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Add Item</button>
                </div>
            </form>
        </div>
    </div>
</main>