<div class="table-responsive h-full">
    <table class="table table-striped">
        <thead>
            <th class="w-[8ch]">ID</th>
            <th>Requester</th>
            <th>Requested Username</th>
            <th class="w-[16ch]">Date Requested</th>
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
    </table>
</div>