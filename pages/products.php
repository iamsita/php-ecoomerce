<?php
// Get category filter if set
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;

// Get all categories for filter
$categories = get_categories();

// Get products based on category filter
if ($category_id) {
    $products = get_products_by_category($category_id);
} else {
    $products = get_products();
}
?>

<div class="row">
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-header">
                <h3>Categories</h3>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="index.php?page=products" 
                       class="list-group-item <?php echo !$category_id ? 'active' : ''; ?>">
                        All Products
                    </a>
                    <?php foreach ($categories as $category): ?>
                        <a href="index.php?page=products&category=<?php echo $category['id']; ?>" 
                           class="list-group-item <?php echo $category_id == $category['id'] ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if ($product['image']): ?>
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text">
                                <?php echo substr(htmlspecialchars($product['description']), 0, 100) . '...'; ?>
                            </p>
                            <p class="card-text">
                                <strong>Price: $<?php echo number_format($product['price'], 2); ?></strong>
                            </p>
                            <p class="card-text">
                                <small class="text-muted">Category: <?php echo htmlspecialchars($product['category_name']); ?></small>
                            </p>
                            <?php if (is_logged_in()): ?>
                                <form method="post" action="index.php?page=cart">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="action" value="add">
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
                            <?php else: ?>
                                <a href="index.php?page=login" class="btn btn-primary">Login to Buy</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div> 