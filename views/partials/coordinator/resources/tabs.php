<style>

.nav-item .nav-link {
    padding: 0.5rem 1rem !important; /* Ensure consistent padding for all tabs */
    font-size: 1rem !important;       /* Ensure consistent font size */
    display: inline-block;            /* Ensure consistent display behavior */
    box-sizing: border-box;          /* Ensure padding and border do not affect size */
    border: 1px solid transparent;   /* Consistent border for all tabs */
}

/* Style for the active tab */
.nav-item .nav-link.active {
    color: #434F72 !important;               /* Active text color */
}

/* Remove extra space caused by the dropdown when active */
.nav-item.dropdown .nav-link {
    padding-right: 0.8rem !important; /* Ensure no extra padding due to dropdown */
    padding-top: 1.25rem !important;
    padding-bottom: 1.2rem !important;
}

/* Optionally, remove the dropdown indicator icon when it's active (if any) */
.nav-item .nav-link.dropdown-toggle::after {
    display: none !important; /* Remove dropdown arrow when the tab is active */
}

/* Optional: Active state for dropdown items */
.nav-item .dropdown-menu .dropdown-item.active {
    background-color: #f1f1f1 !important; /* Active background for dropdown items */
    color: #007bff !important;             /* Active text color for dropdown items */
}

/* Set padding for dropdown items */
.nav-item .dropdown-menu .dropdown-item {
    padding: 0.3rem 1rem !important; /* Ensure dropdown items have consistent padding */
}
    /* Ensure dropdown toggle behaves like a normal tab */
    .nav-item.dropdown {
        position: relative;
        top:2.4rem;
        margin-left:-0rem;
        margin-right: -4rem;
    }

    /* Ensure the dropdown menu aligns under the dropdown toggle */
    .dropdown-menu {
        margin-top: 0; /* Removes any extra margin */
        top: 100%; /* Ensures dropdown appears directly below the dropdown button */
    }
</style>

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
    <li class="nav-item dropdown">
        <a 
            class="nav-link dropdown-toggle <?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/requests' ? 'active' : '' ?>" 
            href="#" 
            id="requestsDropdown" 
            role="button" 
            data-bs-toggle="dropdown" 
            aria-expanded="false">
            Requests
        </a>
        <ul class="dropdown-menu" aria-labelledby="requestsDropdown">
            <li>
                <a class="dropdown-item <?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/requests' ? '' : '' ?>" href="/coordinator/resources/requests">Add Item Requests</a>
            </li>
            <li>
                <a class="dropdown-item <?php echo $_SERVER['REQUEST_URI'] === '/coordinator/resources/edit-requests' ? '' : '' ?>" href="/coordinator/resources/edit-requests">Edit Item Request</a>
            </li>
        </ul>
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
