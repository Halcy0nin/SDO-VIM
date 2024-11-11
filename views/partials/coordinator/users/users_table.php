<div class="table-responsive inline-block mt-4 bg-zinc-50 rounded border-[1px]">
    <table class="table table-striped m-0">
        <thead>
            <th class="w-[5ch]">
                <div class="header-content">
                    ID
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(0)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(0)"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Username
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(1)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(1)"></i>
                    </span>
                </div>
            </th>
            <th class="w-[12ch]">
                <div class="header-content">
                    Role
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(2)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(2)"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    School
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(3)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(3)"></i>
                    </span>
                </div>
            </th>
            <th>
                <div class="header-content">
                    Contact Name
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(4)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(4)"></i>
                    </span>
                </div>
            </th>
            <th class="w-[16ch]">
                <div class="header-content">
                    Mobile Number
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(5)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(5)"></i>
                    </span>
                </div>
            </th>
            <th class="w-[24ch]">
                <div class="header-content">
                    Email
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(6)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(6)"></i>
                    </span>
                </div>
            </th>
            <th class="w-[12ch]">
                <div class="header-content">
                    Date Added
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(7)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(7)"></i>
                    </span>
                </div>
            </th>
            <th class="w-[12ch]">
                <div class="header-content">
                    Date Modified
                    <span class="sort-icons">
                        <i class="fas fa-sort-up sort-icon" onclick=" sortTable(8)"></i>
                        <i class="fas fa-sort-down sort-icon" onclick=" sortTable(8)"></i>
                    </span>
                </div>
            </th>
            <th class="w-[16ch]">Actions</th>
        </thead>
        <tbody>
            <?php if (count($users) > 0): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_id']) ?></td>
                        <td><?= htmlspecialchars($user['user_name']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><?= htmlspecialchars($user['school'] ?? '') ?></td>
                        <td><?= htmlspecialchars($user['contact_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($user['contact_no'] ?? '') ?></td>
                        <td><?= htmlspecialchars($user['contact_email'] ?? '') ?></td>
                        <td><?= htmlspecialchars(formatTimestamp($user['date_added'])) ?></td>
                        <td><?= htmlspecialchars(formatTimestamp($user['date_modified'])) ?></td>
                        <td>
                            <div class="h-full w-full flex items-center gap-2">
                                <?php require base_path('views/partials/coordinator/users/password_change_modal.php') ?>
                                <?php require base_path('views/partials/coordinator/users/edit_user_modal.php') ?>
                                <?php require base_path('views/partials/coordinator/users/delete_user_modal.php') ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">
                        <div class="h-full w-full flex items-center gap-2">
                            No Users Found
                        </div>
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