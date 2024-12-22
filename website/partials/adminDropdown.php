<li class="nav-item dropdown text-center mx-2 mx-lg-1 rounded">
    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        <div>
            <i class="fa-solid fa-user-tie"></i>
            Admin
        </div>
    </a>
    <ul class="dropdown-menu rounded border-1 border-black" aria-labelledby="adminDropdown">
        <li><a class="dropdown-item" href="<?php echo HTML_ROOT_DIR?>/website/admin/userManagement.php">
                <i class="fa-solid fa-users"></i>
                Manage Users
            </a></li>
        <li><a class="dropdown-item" href="<?php echo HTML_ROOT_DIR?>/website/admin/logFiles">
                <i class="fa-solid fa-file-lines"></i>
                View Log Files
            </a></li>
        <li><a class="dropdown-item" href="<?php echo HTML_ROOT_DIR?>/website/admin/productManagement.php">
                <i class="fa-solid fa-boxes-stacked"></i>
                Manage Products
            </a></li>
        <li><a class="dropdown-item" href="<?php echo HTML_ROOT_DIR?>/website/admin/orderManagement.php">
                <i class="fa-solid fa-truck"></i>
                Manage Orders
            </a></li>
        <li><a class="dropdown-item" href="<?php echo HTML_ROOT_DIR?>/website/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a></li>
    </ul>
</li>