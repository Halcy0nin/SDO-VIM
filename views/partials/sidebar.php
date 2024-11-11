<main class="sidebar">
    <img src="/sdo.png" class="sidebar-icon" />
    <ul class="sidebar-list">
        <?php if ($_SESSION['user'] ?? false) : ?>
            <?php if ($_SESSION['user']['role'] === 1) : ?>
                <a href="/coordinator" class="<?php echo $_SERVER['REQUEST_URI'] === '/coordinator' ? 'sidebar-li-alt' : 'sidebar-li' ?>">
                    <i class="bi bi-bar-chart-line-fill sidebar-li-icon"></i>
                    <h6 class="sidebar-li-text">Dashboard</h6>
                </a>
                <a href="/coordinator/resources" class="<?php echo str_contains($_SERVER['REQUEST_URI'], 'resources') ? 'sidebar-li-alt' : 'sidebar-li' ?>">
                    <i class="bi bi-box-seam-fill sidebar-li-icon"></i>
                    <h6 class="sidebar-li-text">Resources</h6>
                </a>
                <a href="/coordinator/schools" class="<?php echo str_contains($_SERVER['REQUEST_URI'], 'schools') ? 'sidebar-li-alt' : 'sidebar-li' ?>">
                    <i class="bi bi-building-fill sidebar-li-icon"></i>
                    <h6 class="sidebar-li-text">Schools</h6>
                </a>
                <a href="/coordinator/users" class="<?php echo str_contains($_SERVER['REQUEST_URI'], 'users') ? 'sidebar-li-alt' : 'sidebar-li' ?>">
                    <i class="bi bi-people-fill sidebar-li-icon"></i>
                    <h6 class="sidebar-li-text">Users</h6>
                </a>
            <?php elseif ($_SESSION['user']['role'] === 2) : ?>
                <a href="/custodian" class="<?php echo $_SERVER['REQUEST_URI'] === '/custodian' ? 'sidebar-li-alt' : 'sidebar-li' ?>">
                    <i class="bi bi-bar-chart-line-fill sidebar-li-icon"></i>
                    <h6 class="sidebar-li-text">Dashboard</h6>
                </a>
                <a href="/custodian/custodian-inventory" class="<?php echo str_contains($_SERVER['REQUEST_URI'], 'custodian-inventory') ? 'sidebar-li-alt' : 'sidebar-li' ?>">
                    <i class="bi bi-clipboard2-data-fill"></i>
                    <h6 class="sidebar-li-text">Inventory</h6>
                </a>
                <a href="/custodian/custodian-resources" class="<?php echo str_contains($_SERVER['REQUEST_URI'], 'resources') ? 'sidebar-li-alt' : 'sidebar-li' ?>">
                    <i class="bi bi-box-seam-fill sidebar-li-icon"></i>
                    <h6 class="sidebar-li-text">Resources</h6>
                </a>
                <a href="/custodian/profile" class="<?php echo str_contains($_SERVER['REQUEST_URI'], 'profile') ? 'sidebar-li-alt' : 'sidebar-li' ?>">
                    <i class="bi bi-person-fill sidebar-li-icon"></i>
                    <h6 class="sidebar-li-text">Profile</h6>
                </a>
            <?php endif; ?>
            <div class="w-full h-[1px] bg-slate-500 mt-2" />
            <form method="POST" action="/" style="width: 100%; margin-top: 1rem;">
                <input type="hidden" name="_method" value="DELETE" />
                <button class="logout">
                    <i class="bi bi-escape sidebar-li-icon"></i>
                    <h6 class="sidebar-li-text">Sign Out</h6>
                </button>
            </form>
        <?php else : ?>
            <a href="/" class="sidebar-li-alt">
                <i class="bi bi-person-fill sidebar-li-icon"></i>
                <h6 class="sidebar-li-text">Sign In</h6>
            </a>
        <?php endif; ?>
    </ul>
</main>