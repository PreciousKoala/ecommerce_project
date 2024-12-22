<li class="nav-item dropdown text-center mx-2 mx-lg-1 rounded">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        <div>
            <i class="fas fa-user fa-lg mb-3"></i>
            User
        </div>
    </a>
    <ul class="dropdown-menu rounded border-1 border-secondary" aria-labelledby="userDropdown">
        <li><a class="dropdown-item" href="<?php echo HTML_ROOT_DIR?>/website/user/userProfile.php">
                <i class="fa-solid fa-address-card"></i>
                Profile
            </a></li>
        <li><a class="dropdown-item" href="<?php echo HTML_ROOT_DIR?>/website/user/userFavorites.php">
                <i class="fa-solid fa-star"></i>
                Favorites
            </a></li>
        <li><a class="dropdown-item" href="<?php echo HTML_ROOT_DIR?>/website/user/orderHistory.php">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Order History
            </a></li>
        <li><a class="dropdown-item" href="<?php echo HTML_ROOT_DIR?>/website/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a></li>
    </ul>
</li>