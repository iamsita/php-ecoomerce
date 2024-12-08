<?php
if (!isset($_SESSION['user_id']) || !is_admin()) {
    header('Location: index.php?page=login');
    exit;
}

$admin_page = $_GET['admin_page'] ?? 'dashboard';
?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="index.php?page=admin&admin_page=dashboard" class="list-group-item">Dashboard</a>
            <a href="index.php?page=admin&admin_page=products" class="list-group-item">Products</a>
            <a href="index.php?page=admin&admin_page=categories" class="list-group-item">Categories</a>
            <a href="index.php?page=admin&admin_page=orders" class="list-group-item">Orders</a>
        </div>
    </div>
    <div class="col-md-9">
        <?php
        switch ($admin_page) {
            case 'products':
                include 'admin/products.php';
                break;
            case 'categories':
                include 'admin/categories.php';
                break;
            case 'orders':
                include 'admin/orders.php';
                break;
            default:
                include 'admin/dashboard.php';
                break;
        }
        ?>
    </div>
</div> 