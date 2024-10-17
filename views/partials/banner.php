<main class="banner-main">
    <h2 class="banner-text">
        <?= $heading ?? "Welcome Coordinator" ?>
    </h2>
    <button class="notification-container relative flex items-center justify-center" type="button" data-bs-toggle="modal" data-bs-target="#notificationModal">
        <i class="bi bi-bell-fill"></i>
        <?php if ($notificationCount > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo $notificationCount; ?>
            </span>
        <?php endif; ?>
    </button>
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-bell-fill"></i> Recent Notifications</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body flex flex-col gap-2">
                </div>
                <div class="modal-footer m-0 p-0">
                    <?php if ($_SESSION['user']['role'] === 2): ?>
                        <a href="/notifications/custodian" class="w-full h-full text-center px-1 py-2 view-all">View All Notifications</a>
                    <?php else: ?>
                        <a href="/notifications" class="w-full h-full text-center px-1 py-2 view-all">View All Notifications</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const notificationModal = document.getElementById('notificationModal');
        const modalBody = notificationModal.querySelector('.modal-body');

        let apiUrl = '/notifications/latest'; 

        <?php if ($_SESSION['user']['role'] === 2): ?>
            apiUrl = '/notifications/custodian/latest';
        <?php endif; ?>

        axios.get(apiUrl)
            .then(response => {
                const notifications = response.data.data;
                if (notifications.length > 0) {
                    notifications.forEach(notification => {
                        const notificationElement = `
                                <div class="w-full rounded border-[1px] border-zinc-100 bg-zinc-50 p-2">
                                    <h5 class="font-bold text-xl text-[#434F72]">${notification.title}</h5>
                                    <p class="ml-1 opacity-95">${notification.message}</p>
                                    <small style="color: rgb(161 161 170); font-style: italic; font-size: 0.875rem; line-height: 1.25rem;">${new Date(notification.date_added).toLocaleString()}</small>
                                </div>`;
                        modalBody.insertAdjacentHTML('beforeend', notificationElement);
                    });
                } else {
                    modalBody.innerHTML = '<p>No new notifications</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
                modalBody.innerHTML = '<p>Error loading notifications</p>';
            });
    });
</script>
