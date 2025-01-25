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
            Requests
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo str_contains($_SERVER['REQUEST_URI'], 'archived') ? 'active' : '' ?>"
            aria-current="<?php echo str_contains($_SERVER['REQUEST_URI'], 'archived') ? 'page' : '' ?>"
            href="/coordinator/users/archived">
            Archived
        </a>
    </li>
</ul>