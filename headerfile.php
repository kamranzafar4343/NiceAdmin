<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
    <img class="navbar-image" src="assets/img/logo3.png" alt="">
    <a href="index.php" class="logo d-flex align-items-center">

        <span class="d-none d-lg-block">FingerLog</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<!-- 
<div class="search-bar">
<form class="search-form d-flex align-items-center" method="POST" action="#">
<input type="text" name="query" placeholder="Search" title="Enter search keyword">
<button type="submit" title="Search"><i class="bi bi-search"></i></button>
</form>
</div>
End Search Bar -->

<nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle " href="#">
                <i class="bi bi-search"></i>
            </a>
        </li><!-- End Search Icon-->


        <li class="nav-item profileimage dropdown pe-3 mr-4">

            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="image/admin-png.png" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $adminName ?></span>
            </a><!-- End Profile Image Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                    <h6><?php echo $adminName ?></h6>
                    <span><?php echo $adminEmail ?></span>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
        </li>
        <li>
            <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
        </li>

    </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

    </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->
