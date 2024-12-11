<ul class="nav nav-tabs">
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources' ? 'page' : '' ?>"
            href="/custodian/custodian-resources">
            All
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/unassigned' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/unassigned' ? 'page' : '' ?>"
            href="/custodian/custodian-resources/unassigned">
            Unassigned
        </a>
    </li>
    <li class="nav-item dropdown">
        <a 
            class="nav-link dropdown-toggle <?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/requests' ? 'active' : '' ?>" 
            href="#" 
            id="requestsDropdown" 
            role="button" 
            data-bs-toggle="dropdown" 
            aria-expanded="false">
            Requests
        </a>
        <ul class="dropdown-menu" aria-labelledby="requestsDropdown">
            <li>
                <a class="dropdown-item <?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/requests' ? '' : '' ?>" href="/custodian/custodian-resources/requests">Add Item Requests</a>
            </li>
            <li>
                <a class="dropdown-item <?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/edit-requests' ? '' : '' ?>" href="/custodian/custodian-resources/edit-requests">Edit Item Request</a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/assigned' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/assigned' ? 'page' : '' ?>"
            href="/custodian/custodian-resources/assigned">
            Assigned
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/working' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/working' ? 'page' : '' ?>"
            href="/custodian/custodian-resources/working">
            Working
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/repair' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/repair' ? 'page' : '' ?>"
            href="/custodian/custodian-resources/repair">
            For Repair
        </a>
    </li>
    <li class="nav-item">
        <a
            class="nav-link <?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/condemned' ? 'active' : '' ?>"
            aria-current="<?php echo $_SERVER['REQUEST_URI'] === '/custodian/custodian-resources/condemned' ? 'page' : '' ?>"
            href="/custodian/custodian-resources/condemned">
            Condemned
        </a>
    </li>
</ul>