<ul class="nav nav-tabs">
    <li class="nav-item">
        <a
            class="nav-link <?php echo  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/coordinator/resources' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources' ? 'page' : '' ?>"
            href="/coordinator/resources">      
            All
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo str_contains($_SERVER['REQUEST_URI'], 'unassigned') ? 'active' : '' ?>"
            aria-current="<?php echo str_contains($_SERVER['REQUEST_URI'], 'unassigned') ? 'page' : '' ?>"
            href="/coordinator/resources/unassigned">
            Unassigned
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo str_contains($_SERVER['REQUEST_URI'], 'working') ? 'active' : '' ?>"
            aria-current="<?php echo str_contains($_SERVER['REQUEST_URI'], 'working') ? 'page' : '' ?>"
            href="/coordinator/resources/working">
            Working
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo str_contains($_SERVER['REQUEST_URI'], 'repair') ? 'active' : '' ?>"
            aria-current="<?php echo str_contains($_SERVER['REQUEST_URI'], 'repair') ? 'page' : '' ?>"
            href="/coordinator/resources/repair">
            For Repair
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo str_contains($_SERVER['REQUEST_URI'], 'condemned') ? 'active' : '' ?>"
            aria-current="<?php echo str_contains($_SERVER['REQUEST_URI'], 'condemned') ? 'page' : '' ?>"
            href="/coordinator/resources/condemned">
            Condemned
        </a>
    </li>
</ul>