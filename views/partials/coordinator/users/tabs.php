<ul class="nav nav-tabs">
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/coordinator/users' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/coordinator/users' ? 'page' : '' ?>"
            href="/coordinator/users">
            All Users
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo str_contains($_SERVER['REQUEST_URI'], 'pending') ? 'active' : '' ?>"
            aria-current="<?php echo str_contains($_SERVER['REQUEST_URI'], 'pending') ? 'page' : '' ?>"
            href="/coordinator/users/pending">
            Pending Requests
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo str_contains($_SERVER['REQUEST_URI'], 'approved') ? 'active' : '' ?>"
            aria-current="<?php echo str_contains($_SERVER['REQUEST_URI'], 'approved') ? 'page' : '' ?>"
            href="/coordinator/users/approved">
            Approved Requests
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo str_contains($_SERVER['REQUEST_URI'], 'denied') ? 'active' : '' ?>"
            aria-current="<?php echo str_contains($_SERVER['REQUEST_URI'], 'denied') ? 'page' : '' ?>"
            href="/coordinator/users/denied">
            Denied Requests
        </a>
    </li>
</ul>