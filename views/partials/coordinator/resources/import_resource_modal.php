<!-- Modal Button -->

<button class="flex items-center w-fit shrink-0 px-3 py-2 rounded shadow-md bg-blue-500  text-white gap-2 font-bold hover:bg-blue-600" data-bs-toggle="modal" data-bs-target="#importResourceModal">
    <i class="bi bi-upload"></i>
    <p>Import</p>
</button>

<!-- Modal -->

<main class="modal fade " id="importResourceModal" tabindex="-1" aria-labelledby="importResourceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <div class="modal-body h-fit flex flex-col gap-2">
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-blue-600 text-xl">
                        <i class="bi bi-file-earmark-arrow-up-fill"></i>
                        <h1 class="modal-title fs-5 font-bold" id="importResourceLabel">Import Resources</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex items-center">
                    <p>Fill-up the provided form <a href="/uploads/import_resource_form" class="text-blue-500 font-bold">here <i class="bi bi-download"></i></a></p>
                </div>
                <form action="/coordinator/resources/importcsv" method="POST" enctype="multipart/form-data" class="w-full flex flex-col gap-3">
                    Upload The Form Below:
                    <input class="block file:px-2 file:py-1 text-zinc-500 border border-gray-300 rounded-lg cursor-pointer bg-zinc-50 focus:outline-none file:text-zinc-100 file:border-0 file:bg-[#434F72] file:text-foreground" name="uploadedForm" id="formFile" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-exce">
                    <div class="modal-footer mt-4 w-full">
                        <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn font-bold text-white bg-blue-500 hover:bg-blue-400">Import</button>
                    </div>
                </form>
                <?php if (isset($errors['import_resources']['uploadedForm'])): ?>
                    <p class="error"><?= $errors['import_resources']['uploadedForm'] ?></p>
                <?php endif; ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (<?php echo json_encode(isset($errors['import_resources']) &&  count($errors['import_resources']) > 0); ?>) {
                            var importResourceModal = new bootstrap.Modal(document.getElementById('importResourceModal'));
                            importResourceModal.show();
                        }
                    });
                </script>

            </div>
        </div>
</main>