<!-- Modal button -->
<button class="view-btn" data-bs-toggle="modal" data-bs-target="#editRequestModal<?php echo $request['id']; ?>">
    <i class="bi bi-eye-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="editRequestModal<?php echo $request['id']; ?>" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/resources/edit-requests" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="_method" value="PATCH" hidden />
                <input name="request_to_update" value="<?php echo $request["id"]; ?>" hidden />
                <input name="id" value="<?php echo $request["school_id"]; ?>" hidden />
                <input name="item_code" value="<?php echo $request["item_code"]; ?>" hidden />
                <input name="item_article" value="<?php echo $request["item_article"]; ?>" hidden />
                <input name="item_desc" value="<?php echo $request["item_desc"]; ?>" hidden />
                <input name="item_unit_value" value="<?php echo $request["item_unit_value"]; ?>" hidden />
                <input name="item_quantity" value="<?php echo $request["item_quantity"]; ?>" hidden />
                <input name="item_active" value="<?php echo $request["item_active"]; ?>" hidden />
                <input name="item_inactive" value="<?php echo $request["item_inactive"]; ?>" hidden />
                <input name="item_funds_source" value="<?php echo $request["item_funds_source"]; ?>" hidden />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-check-square-fill"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addUserModalLabel">Edit Request</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Item Article: 
                    <span style="font-weight: 400; color: #000;"><?php echo $request['item_article']; ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Old Item Article: 
                    <span style="font-weight: 400; color: #000;">
                        <?php 
                            // Loop through oldValues to find the corresponding old value
                            foreach ($oldValues as $old) {
                                if ($old['item_code'] === $request['item_code']) {
                                    echo htmlspecialchars($old['item_article']);
                                    break; // Stop after the first match
                                }
                            }
                            ?> 
                    </span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Item Description: 
                    <span style="font-weight: 400; color: #000;"><?php echo $request['item_desc']; ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Old Item Description: 
                    <span style="font-weight: 400; color: #000;">
                        <?php 
                            // Loop through oldValues to find the corresponding old value
                            foreach ($oldValues as $old) {
                                if ($old['item_code'] === $request['item_code']) {
                                    echo htmlspecialchars($old['item_desc']);
                                    break; // Stop after the first match
                                }
                            }
                            ?> 
                    </span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Unit Value: PHP 
                    <span style="font-weight: 400; color: #000;"><?php echo $request['item_unit_value']; ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Old Unit Value: 
                    <span style="font-weight: 400; color: #000;">
                        <?php 
                            // Loop through oldValues to find the corresponding old value
                            foreach ($oldValues as $old) {
                                if ($old['item_code'] === $request['item_code']) {
                                    echo htmlspecialchars($old['item_unit_value']);
                                    break; // Stop after the first match
                                }
                            }
                            ?> 
                    </span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Quantity: 
                    <span style="font-weight: 400; color: #000;"><?php echo $request['item_quantity']; ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Old Quantity: 
                    <span style="font-weight: 400; color: #000;">
                        <?php 
                            // Loop through oldValues to find the corresponding old value
                            foreach ($oldValues as $old) {
                                if ($old['item_code'] === $request['item_code']) {
                                    echo htmlspecialchars($old['item_quantity']);
                                    break; // Stop after the first match
                                }
                            }
                            ?> 
                    </span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Funds Source: 
                    <span style="font-weight: 400; color: #000;"><?php echo $request['item_funds_source']; ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-bottom: 12px; color: #434F72; font-family: 'Roboto', sans-serif; font-weight: 700;">
                    Old Funds Source: 
                    <span style="font-weight: 400; color: #000;">
                        <?php 
                            // Loop through oldValues to find the corresponding old value
                            foreach ($oldValues as $old) {
                                if ($old['item_code'] === $request['item_code']) {
                                    echo htmlspecialchars($old['item_funds_source']);
                                    break; // Stop after the first match
                                }
                            }
                            ?> 
                    </span>
                </h1>
                <?php if ($request['item_request_status'] == 0): ?>
                    <h1 style="font-size: 1.1em; margin-top: 50px; color: #434F72; font-family: 'Roboto', sans-serif;">
                        Are you sure you want to apply these changes to: 
                        <b style="color: #2c3e50;"><?php echo $request['item_code']; ?></b> to be added to: 
                        <b style="color: #2c3e50;"><?php echo $request['school_name']; ?></b>?
                    </h1>
                <?php endif; ?>
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <?php if ($request['item_request_status'] == 0): ?>
                        <button type="submit" class="btn font-bold text-white bg-red-500 hover:bg-red-400">Reject</button>
                        <button name="approve_request" type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Approve</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</main>