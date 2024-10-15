<!-- Modal Button -->

<button class="flex items-center w-fit shrink-0 px-3 py-2 rounded shadow-md bg-blue-500 text-white gap-2 font-bold" data-bs-toggle="modal" data-bs-target="#exportUserModal">
    <i class="bi bi-file-earmark-ruled-fill"></i>
    <p>Export Users</p>
</button>

<!-- Modal -->

<main class="modal fade " id="exportUserModal" tabindex="-1" aria-labelledby="exportUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
            <div class="modal-body h-fit flex flex-col gap-2">
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-building-fill-add"></i>
                        <h1 class="modal-title fs-5 font-bold" id="exportUserLabel">Export Users</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="flex gap-1 ms-3">
                    Are you sure you want to export this data?
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <form action="#" method="POST">
                        <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Export as PDF</button>
                    </form>
                    <form action="/coordinator/users/exportcsv" method="POST">
                        <button type="submit" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Export as CSV</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</main>