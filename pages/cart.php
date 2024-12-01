<?php
if (!is_logged_in()) {
    $_SESSION['redirect_after_login'] = 'index.php?page=cart';
    header('Location: index.php?page=login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $product_id => $quantity) {
            if ($quantity > 0) {
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            } else {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    } elseif (isset($_POST['checkout'])) {
        $order_id = create_order($_SESSION['user_id']);
        if ($order_id) {
            header('Location: index.php?page=orders');
            exit;
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h2>Shopping Cart</h2>
    </div>
    <div class="card-body">
        <?php if (!empty($_SESSION['cart'])): ?>
            <form method="post">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <input type="number" name="quantity[<?php echo $product_id; ?>]" 
                                           value="<?php echo $item['quantity']; ?>" min="0" class="form-control" 
                                           style="width: 80px;">
                                </td>
                                <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong>$<?php echo number_format(get_cart_total(), 2); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-end">
                    <button type="submit" name="update_cart" class="btn btn-secondary">Update Cart</button>
                    <button type="submit" name="checkout" class="btn btn-primary">Checkout (Cash on Delivery)</button>
                </div>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</div> 