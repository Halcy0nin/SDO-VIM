<div class="table-responsive inline-block mt-0 bg-zinc-50 rounded border-[1px]">
    <table class="table table-striped">
        <thead>
            <th class="w-[8ch]">ID</th>
            <th>Requester</th>
            <th>Requested Username</th>
            <th class="w-[5ch]">Date Requested</th>
            <?php if ($options ?? false): ?>
                <th class="w-[12ch]">Actions</th>
            <?php endif; ?>
        </thead>
        <tbody>
            <?php if (isset($requests)): ?>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['request_id']) ?></td>
                        <td><?= htmlspecialchars($request['user_name']) ?></td>
                        <td><?= htmlspecialchars($request['new_username']) ?></td>
                        <td><?= htmlspecialchars($request['date_requested']) ?></td>
                        <?php if ($options ?? false): ?>
                            <td>
                                <div class="h-full w-full flex items-center gap-2">
                                    <?php require base_path('views/partials/coordinator/users/approve.php') ?>
                                    <?php require base_path('views/partials/coordinator/users/deny.php') ?>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr rowspan="10" class="h-full">
                    <td colspan="6" class="text-center">
                        There are no Requests.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot class="overflow-hidden">
            <tr>
                <td colspan="10" class="py-2 pr-4">
                    <div class="w-full flex items-center justify-end gap-2">
                        <p class="grow text-end mr-2">Page - <?= htmlspecialchars($pagination['pages_current']) ?> / <?= htmlspecialchars($pagination['pages_total']) ?></p>
                        <?php if ($pagination['pages_total'] > 1): ?>
                            <a
                                href="/coordinator/users?page=1"
                                class="pagination-link">
                                <i class="bi bi-chevron-bar-left"></i>
                            </a>
                            <a
                                href="/coordinator/users?page=<?= htmlspecialchars($pagination['pages_current'] <= 1 ? 1 : $pagination['pages_current'] - 1) ?>" class="pagination-link">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                            <a href="/coordinator/users?page=<?= htmlspecialchars($pagination['pages_current'] >= $pagination['pages_total'] ? $pagination['pages_total'] : $pagination['pages_current'] + 1) ?>"
                                class="pagination-link">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                            <a href="/coordinator/users?page=<?= htmlspecialchars($pagination['pages_total']) ?>"
                                class="pagination-link">
                                <i class="bi bi-chevron-bar-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>