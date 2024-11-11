<!-- Modal Button -->

<button class="view-btn" data-bs-toggle="modal" data-bs-target="#viewReceiptModal<?= $school['school_id'] ?>">
    <i class="bi bi-eye-fill"></i>
</button>

<!-- Modal -->

<main class="modal fade " id="viewReceiptModal<?= $school['school_id'] ?>" tabindex="-1" aria-labelledby="viewReceiptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content p-2">
            <div class="modal-header mb-4">
                <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                    <i class="bi bi-receipt-cutoff"></i>
                    <h1 class="modal-title fs-5 font-bold" id="exportSchoolLabel">View Receipt</h1>
                </div>
                <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php if (isset($school['receipt'])) : ?>
                <img class="mb-2 border-2 border-[#434F72] rounded" src="<?php echo '/' . $school['receipt'] ?>">
                <p class="text-sm mb-4"><?php echo $school['school_name'] ?>'s receipt issued in <?php echo formatTimestamp($school['receipt_date_added'], 'M d, Y g:i A ') ?></p>
            <?php else : ?>
                <p class="text-sm mb-4 ml-2"><?php echo $school['school_name'] ?> has no receipts uploaded.</p>
            <?php endif; ?>
        </div>
    </div>
</main>