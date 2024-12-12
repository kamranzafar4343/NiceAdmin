<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard Link (Visible to all users) -->
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : 'collapsed'; ?>" href="index.php">
                <i class="ri-home-8-line"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <?php if ($_SESSION['role'] == 'admin') { ?>
            <!-- Admin-only Links -->
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == 'Companies.php') ? 'active' : 'collapsed'; ?>" href="Companies.php">
                    <i class="ri-building-4-line"></i><span>Clients</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Companies Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == 'box.php') ? 'active' : 'collapsed'; ?>" href="box.php">
                    <i class="bi bi-box"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Boxes Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == 'showItems.php') ? 'active' : 'collapsed'; ?>" href="showItems.php">
                    <i class="ri-file-copy-2-line"></i><span>Files</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Items Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == 'order.php' || $currentPage == 'pickup.php' || $currentPage == 'permout.php' || $currentPage == 'destroy.php' || $currentPage == 'access.php' || $currentPage == 'supplies.php') ? 'active' : 'collapsed'; ?>" data-bs-toggle="collapse" data-bs-target="#forms-nav" href="#">
                    <i class="ri-list-ordered"></i><span>Work Orders</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse <?php echo ($currentPage == 'order.php' || $currentPage == 'pickup.php' || $currentPage == 'permout.php' || $currentPage == 'destroy.php' || $currentPage == 'access.php' || $currentPage == 'supplies.php') ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link <?php echo ($currentPage == 'order.php') ? 'active' : ''; ?>" href="order.php">
                            <i class="bi bi-circle"></i><span>Delivery</span>
                        </a>
                        <a class="nav-link <?php echo ($currentPage == 'pickup.php') ? 'active' : ''; ?>" href="pickup.php">
                            <i class="bi bi-circle"></i><span>Pickup</span>
                        </a>
                        <a class="nav-link <?php echo ($currentPage == 'permout.php') ? 'active' : ''; ?>" href="permout.php">
                            <i class="bi bi-circle"></i><span>Perm Out</span>
                        </a>
                        <a class="nav-link <?php echo ($currentPage == 'destroy.php') ? 'active' : ''; ?>" href="destroy.php">
                            <i class="bi bi-circle"></i><span>Destroy</span>
                        </a>
                        <a class="nav-link <?php echo ($currentPage == 'access.php') ? 'active' : ''; ?>" href="access.php">
                            <i class="bi bi-circle"></i><span>Access</span>
                        </a>
                        <a class="nav-link <?php echo ($currentPage == 'supplies.php') ? 'active' : ''; ?>" href="supplies.php">
                            <i class="bi bi-circle"></i><span>Supplies</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == 'racks.php') ? 'active' : 'collapsed'; ?>" href="racks.php">
                    <i class="bi bi-box"></i><span>Racks</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Racks Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == 'store.php') ? 'active' : 'collapsed'; ?>" href="store.php">
                    <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Store Nav -->

        <?php } else { ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == 'box.php') ? 'active' : 'collapsed'; ?>" href="box.php">
                    <i class="bi bi-box"></i><span>Boxes</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Boxes Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == 'showItems.php') ? 'active' : 'collapsed'; ?>" href="showItems.php">
                    <i class="ri-shopping-cart-line"></i><span>Files</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Items Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == 'order.php' || $currentPage == 'pickup.php' || $currentPage == 'permout.php' || $currentPage == 'destroy.php' || $currentPage == 'access.php' || $currentPage == 'supplies.php') ? 'active' : 'collapsed'; ?>" data-bs-toggle="collapse" data-bs-target="#forms-nav" href="#">
                    <i class="ri-list-ordered"></i><span>Work Orders</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse <?php echo ($currentPage == 'order.php' || $currentPage == 'pickup.php' || $currentPage == 'permout.php' || $currentPage == 'destroy.php' || $currentPage == 'access.php' || $currentPage == 'supplies.php') ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link <?php echo ($currentPage == 'order.php') ? 'active' : ''; ?>" href="order.php">
                            <i class="bi bi-circle"></i><span>Delivery</span>
                        </a>
                        <a class="nav-link <?php echo ($currentPage == 'pickup.php') ? 'active' : ''; ?>" href="pickup.php">
                            <i class="bi bi-circle"></i><span>Pickup</span>
                        </a>
                        <a class="nav-link <?php echo ($currentPage == 'permout.php') ? 'active' : ''; ?>" href="permout.php">
                            <i class="bi bi-circle"></i><span>Perm Out</span>
                        </a>
                        <a class="nav-link <?php echo ($currentPage == 'destroy.php') ? 'active' : ''; ?>" href="destroy.php">
                            <i class="bi bi-circle"></i><span>Destroy</span>
                        </a>
                        <a class="nav-link <?php echo ($currentPage == 'access.php') ? 'active' : ''; ?>" href="access.php">
                            <i class="bi bi-circle"></i><span>Access</span>
                        </a>
                        <a class="nav-link <?php echo ($currentPage == 'supplies.php') ? 'active' : ''; ?>" href="supplies.php">
                            <i class="bi bi-circle"></i><span>Supplies</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == 'racks.php') ? 'active' : 'collapsed'; ?>" href="racks.php">
                    <i class="bi bi-box"></i><span>Racks</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Racks Nav -->

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage == 'store.php') ? 'active' : 'collapsed'; ?>" href="store.php">
                    <i class="bi bi-shop"></i><span>Store</span><i class="bi bi-chevron ms-auto"></i>
                </a>
            </li><!-- End Store Nav -->

        <?php } ?>

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'pages-login.php') ? 'active' : 'collapsed'; ?>" href="pages-login.php">
                <i class="bi bi-box-arrow-right"></i><span>Login</span>
            </a>
        </li><!-- End Login Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'logout.php') ? 'active' : 'collapsed'; ?>" href="logout.php">
                <i class="bi bi-box-arrow-left"></i><span>Logout</span>
            </a>
        </li><!-- End Logout Nav -->

    </ul>
</aside>
<!-- End Sidebar -->
