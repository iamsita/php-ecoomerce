<?php
if (! is_logged_in()) {
    $_SESSION['redirect_after_login'] = 'index.php?page=checkout';
    header('Location: index.php?page=login');
    exit;
}

if (empty($_SESSION['cart'])) {
    $_SESSION['message'] = 'Your cart is empty';
    header('Location: index.php?page=cart');
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate checkout data
    if (empty($_POST['shipping_address'])) {
        $errors['shipping_address'] = 'Shipping address is required';
    }
    if (empty($_POST['phone'])) {
        $errors['phone'] = 'Phone number is required';
    }

    if (empty($errors)) {
        $order_data = [
            'user_id' => $_SESSION['user_id'],
            'shipping_address' => $_POST['shipping_address'],
            'billing_address' => $_POST['billing_address'] ?? $_POST['shipping_address'],
            'phone' => $_POST['phone'],
            'email' => $_SESSION['email'],
            'notes' => $_POST['notes'] ?? '',
            'payment_method' => 'cod',
            'total_amount' => get_cart_total(),
        ];

        $order_id = create_order($order_data);
        if ($order_id) {
            $_SESSION['message'] = 'Order placed successfully!';
            header('Location: index.php?page=orders');
            exit;
        } else {
            $errors['general'] = 'Failed to place order. Please try again.';
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h2>Checkout</h2>
    </div>
    <div class="card-body">
        <?php if (! empty($errors['general'])) { ?>
            <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
        <?php } ?>

        <div class="row">
            <div class="col-md-8">
                <form method="post">
                    <div class="mb-3">
                        <label>Shipping Address*</label>
                        <textarea name="shipping_address" class="form-control" rows="3" required><?php echo $_POST['shipping_address'] ?? ''; ?></textarea>
                        <?php if (isset($errors['shipping_address'])) { ?>
                            <div class="text-danger"><?php echo $errors['shipping_address']; ?></div>
                        <?php } ?>
                    </div>

                    <div class="mb-3">
                        <label>Billing Address (if different from shipping)</label>
                        <textarea name="billing_address" class="form-control" rows="3"><?php echo $_POST['billing_address'] ?? ''; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Phone Number*</label>
                        <input type="tel" name="phone" class="form-control" value="<?php echo $_POST['phone'] ?? ''; ?>" required>
                        <?php if (isset($errors['phone'])) { ?>
                            <div class="text-danger"><?php echo $errors['phone']; ?></div>
                        <?php } ?>
                    </div>

                    <div class="mb-3">
                        <label>Order Notes</label>
                        <textarea name="notes" class="form-control" rows="2"><?php echo $_POST['notes'] ?? ''; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Place Order (Cash on Delivery)</button>
                    <a href="index.php?page=cart" class="btn btn-secondary">Back to Cart</a>
                </form>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Order Summary</h3>
                    </div>
                    <div class="card-body">
                        <?php foreach ($_SESSION['cart'] as $product_id => $item) { ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span><?php echo htmlspecialchars($item['name']); ?> (×<?php echo $item['quantity']; ?>)</span>
                                <span>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                            </div>
                        <?php } ?>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong>$<?php echo number_format(get_cart_total(), 2); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 