<div class="sidebar">
  <nav class="nav flex-column">
    <p>Main</p>
    <a class="nav-link <?= $active == 'home' ? 'active' : '' ?>" href="home.php"> <i class="fa-solid fa-gauge-high fa-fw me-2"></i> Dashboard</a>

    <a class="nav-link <?= $active == 'categories' ? 'active' : '' ?>" href="category.php"><i class="fa-solid fa-angle-right fa-fw me-2"></i> Category</a>

    <a class="nav-link <?= $active == 'sub_categories' ? 'active' : '' ?>" href="sub-category.php"><i class="fa-solid fa-angles-right fa-fw me-2"></i> Sub Category</a>

    <a class="nav-link <?= $active == 'save_product' ? 'active' : '' ?>" href="save-product.php"><i class="fa-solid fa-circle-plus fa-fw me-2"></i> Insert Products</a>

    <a class="nav-link <?= $active == 'products' ? 'active' : '' ?>" href="products.php"><i class="fa-solid fa-cloud-meatball fa-fw me-2"></i> Products</a>

    <a class="nav-link <?= $active == 'orders' ? 'active' : '' ?>" href="orders.php?status=Pending"><i class="fa-solid fa-cart-plus fa-fw me-2"></i> Orders</a>
    <p>Other</p>
    <a class="nav-link <?= $active == 'change_password' ? 'active' : '' ?>" href="change-password.php"> <i class="fa-solid fa-unlock fa-fw me-2"></i> Change Password</a>

    <a class="nav-link" href="<?= base_url_admin?>/logout.php"> <i class="fa-solid fa-right-from-bracket fa-fw me-2"></i> Logout</a>
  </nav>
</div>