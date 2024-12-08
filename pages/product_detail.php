<?php
// Get product ID from URL
$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product = get_product($product_id);

// Redirect if product not found
if (! $product) {
    header('Location: index.php?page=products');
    exit;
}

// Handle add to cart action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

    if (add_to_cart($product_id, $quantity)) {
        $_SESSION['message'] = 'Product added to cart successfully';
        header('Location: index.php?page=product_detail&id='.$product_id);
        exit;
    }
}

// Get related products (same category, excluding current product)
$related_products = get_related_products($product['category_id'], $product_id);
?>

<div class="row">
    <div class="col-md-6">
        <?php if ($product['image']) { ?>
            <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                 class="img-fluid rounded" 
                 alt="<?php echo htmlspecialchars($product['name']); ?>">
        <?php } ?>
    </div>
    <div class="col-md-6">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p class="text-muted">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
        <h2 class="text-primary">$<?php echo number_format($product['price'], 2); ?></h2>
        
        <div class="my-4">
            <h3>Description</h3>
            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        </div>

        <?php if (is_logged_in()) { ?>
            <form method="post" class="mb-4">
                <div class="input-group mb-3" style="max-width: 200px;">
                    <label class="input-group-text">Quantity</label>
                    <input type="number" name="quantity" class="form-control" value="1" min="1">
                </div>
                <input type="hidden" name="add_to_cart" value="1">
                <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
            </form>
        <?php } else { ?>
            <a href="index.php?page=login" class="btn btn-primary btn-lg">Login to Buy</a>
        <?php } ?>
    </div>
</div>

<?php if (! empty($related_products)) { ?>
    <div class="mt-5">
        <h3>Related Products</h3>
        <div class="row">
            <?php foreach ($related_products as $related_product) { ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <?php if ($related_product['image']) { ?>
                            <img src="<?php echo htmlspecialchars($related_product['image']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($related_product['name']); ?>"
                                 style="height: 200px; object-fit: cover;">
                        <?php } ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($related_product['name']); ?></h5>
                            <p class="card-text">
                                <strong>$<?php echo number_format($related_product['price'], 2); ?></strong>
                            </p>
                            <a href="index.php?page=product_detail&id=<?php echo $related_product['id']; ?>" 
                               class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?> 