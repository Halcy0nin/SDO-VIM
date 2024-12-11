<!-- Modal Button -->

<div class="parent-container1">
    <button class="move-button" data-bs-toggle="modal" data-bs-target="#untagResourceModal">
        <i class="bi bi-stack"></i>
        <p>Untag Resources</p>
    </button>
</div>
<!-- Modal -->
<main class="modal fade" id="untagResourceModal" tabindex="-1" aria-labelledby="untagResourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-1/2">
        <div class="modal-content">
        <form action="/coordinator/resources/assigned" method="POST" class="modal-body h-fit flex flex-col gap-2">
                <input name="_method" value="PATCH" hidden />
                <div class="modal-header mb-4">
                    <div class="flex gap-2 justify-center items-center text-green-600 text-xl">
                        <i class="bi bi-box-seam-fill sidebar-li-icon"></i>
                        <h1 class="modal-title fs-5 font-bold" id="addItemModalLabel">Untag Resources</h1>
                    </div>
                    <button type="button" class="btn-close hover:text-red-500" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                Are you sure you want to untag these items?
                <div id="selectedItemsContainer"></div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn font-bold text-[#000] hover:text-red-500 border-[1px] border-[#000] hover:border-red-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit"  name="reject_assigned_item" class="btn font-bold text-white bg-green-500 hover:bg-green-400">Unassign</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>


</script>