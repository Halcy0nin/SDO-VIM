<!-- Modal button -->
<button class="view-btn" data-bs-toggle="modal" data-bs-target="#requestResourceModal<?php echo $resource['item_code']; ?>">
    <i class="bi bi-eye-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="requestResourceModal<?php echo $resource['item_code']; ?>" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/resources/requests" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="request_to_update" value="<?php echo $resource["id"]; ?>" hidden />
                <input name="id" value="<?php echo $resource["school_id"]; ?>" hidden />
                <input name="item_code" value="<?php echo $resource["item_code"]; ?>" hidden />
                <input name="item_article" value="<?php echo $resource["item_article"]; ?>" hidden />
                <input name="item_desc" value="<?php echo $resource["item_desc"]; ?>" hidden />
                <input name="item_unit_value" value="<?php echo $resource["item_unit_value"]; ?>" hidden />
                <input name="item_quantity" value="<?php echo $resource["item_quantity"]; ?>" hidden />
                <input name="date_acquired" value="<?php echo $resource["date_acquired"]; ?>" hidden />
                <input name="item_active" value="<?php echo $resource["item_active"]; ?>" hidden />
                <input name="item_inactive" value="<?php echo $resource["item_inactive"]; ?>" hidden />
                <input name="item_funds_source" value="<?php echo $resource["item_funds_source"]; ?>" hidden />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-check-square-fill"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addUserModalLabel">Resource Request</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Item Article: 
                    <span style="font-weight: 400; color: #000;"><?php echo $resource['item_article']; ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Item Description: 
                    <span style="font-weight: 400; color: #000;"><?php echo $resource['item_desc']; ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Quantity: 
                    <span style="font-weight: 400; color: #000;"><?php echo $resource['item_quantity']; ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Total Value: PHP 
                    <span style="font-weight: 400; color: #000;"><?php echo $resource['item_quantity'] * $resource['item_unit_value']; ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Funds Source
                    <span style="font-weight: 400; color: #000;"><?php echo $resource['item_funds_source'] ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Item Active 
                    <span style="font-weight: 400; color: #000;"><?php echo $resource['item_active'] ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Item Inactive 
                    <span style="font-weight: 400; color: #000;"><?php echo $resource['item_inactive'] ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Date Acquired 
                    <span style="font-weight: 400; color: #000;"><?php echo formatTimestamp($resource['date_acquired']) ?></span>
                </h1>
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</main>