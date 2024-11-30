<ul class="nav nav-tabs">
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources' ? 'page' : '' ?>"
            href="/coordinator/resources">
            All
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/unassigned' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/unassigned' ? 'page' : '' ?>"
            href="/coordinator/resources/unassigned">
            Unassigned
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/assigned' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/assigned' ? 'page' : '' ?>"
            href="/coordinator/resources/assigned">
            Assigned
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/requests' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/requests' ? 'page' : '' ?>"
            href="/coordinator/resources/requests">
            Requests
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/working' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/working' ? 'page' : '' ?>"
            href="/coordinator/resources/working">
            Working
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/repair' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/repair' ? 'page' : '' ?>"
            href="/coordinator/resources/repair">
            For Repair
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/condemned' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/condemned' ? 'page' : '' ?>"
            href="/coordinator/resources/condemned">
            Condemned
        </a>
    </li>
</ul>