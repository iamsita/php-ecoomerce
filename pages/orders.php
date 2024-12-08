<?php
if (! is_logged_in()) {
    $_SESSION['redirect_after_login'] = 'index.php?page=orders';
    header('Location: index.php?page=login');
    exit;
}

// Add after authentication check
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Add before the orders list
include 'includes/search_bar.php';

// Get user's orders
$orders = $search_query ? search_user_orders($_SESSION['user_id'], $search_query) : get_user_orders($_SESSION['user_id']);
?>

<div class="card">
    <div class="card-header">
        <h2>My Orders</h2>
    </div>
    <div class="card-body">
        <?php if (empty($orders)) { ?>
            <p>You haven't placed any orders yet.</p>
            <a href="index.php?page=products" class="btn btn-primary">Start Shopping</a>
        <?php } else { ?>
            <?php foreach ($orders as $order) { ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Order #<?php echo $order['id']; ?></h5>
                                </div>
                            <div>
                                <span class="badge bg-<?php echo get_status_color($order['status']); ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h6>Order Items:</h6>
                                <?php $order_items = get_order_items($order['id']); ?>
                                <?php foreach ($order_items as $item) { ?>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>
                                            <?php echo htmlspecialchars($item['product_name']); ?> 
                                            × <?php echo $item['quantity']; ?>
                                        </span>
                                        <span>$<?php echo number_format($item['total_price'], 2); ?></span>
                                    </div>
                                <?php } ?>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong>$<?php echo number_format($order['total_amount'], 2); ?></strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6>Shipping Address:</h6>
                                <p><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                                <h6>Contact:</h6>
                                <p>
                                    Phone: <?php echo htmlspecialchars($order['phone']); ?><br>
                                    Email: <?php echo htmlspecialchars($order['email']); ?>
                                </p>
                                <?php if ($order['notes']) { ?>
                                    <h6>Notes:</h6>
                                    <p><?php echo nl2br(htmlspecialchars($order['notes'])); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div> 