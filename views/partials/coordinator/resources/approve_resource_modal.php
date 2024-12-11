<!-- Modal button -->
<button class="view-btn" data-bs-toggle="modal" data-bs-target="#requestResourceModal<?php echo $resource['item_code']; ?>">
    <i class="bi bi-eye-fill"></i>
</button>

<!-- Modal -->
<main class="modal fade " id="requestResourceModal<?php echo $resource['item_code']; ?>" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <form action="/coordinator/resources/requests" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="_method" value="PATCH" hidden />
                <input name="item_code" value="<?php echo $resource["item_code"]; ?>" hidden />
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
                    <span style="font-weight: 400; color: #000;"><?php echo $resource['item_total_value']; ?></span>
                </h1>
                <h1 style="font-size: 1.1em; margin-top: 50px; color: #434F72; font-family: 'Roboto', sans-serif;">
                    Are you sure you want to approve: 
                    <b style="color: #2c3e50;"><?php echo $resource['item_code']; ?></b> to be added to: 
                    <b style="color: #2c3e50;"><?php echo $resource['school_name']; ?></b>?
                </h1>
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn font-bold text-white bg-red-500 hover:bg-red-400">Reject</button>
                    <button name="approve_request" type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Approve</button>
                </div>
            </form>
        </div>
    </div>
</main>