<?php
// Add this at the top of the file
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

    if (add_to_cart($product_id, $quantity)) {
        $_SESSION['message'] = 'Product added to cart successfully';
        header('Location: index.php?page=home');
        exit;
    }
}

// Add after cart handling
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Add before the products grid
include 'includes/search_bar.php';

// Update featured products query
$featured_products = $search_query ? search_products($search_query) : get_products(20);
?>

<div class="jumbotron text-center bg-light p-4 mb-4">
    <h1>Welcome to Our E-Commerce Store</h1>
    <p class="lead">Discover our amazing products at great prices!</p>
</div>

<h2 class="mb-4">Featured Products</h2>

<div class="row">
    <?php foreach ($featured_products as $product) { ?>
        <div class="col-md-4 mb-4">
            <div class="card product-card">
                <a href="index.php?page=product_detail&id=<?php echo $product['id']; ?>" 
                   class="product-card-link"></a>
                <?php if ($product['image']) { ?>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>"
                         style="height: 200px; object-fit: cover;">
                <?php } ?>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="index.php?page=product_detail&id=<?php echo $product['id']; ?>" 
                           class="text-decoration-none text-dark">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </a>
                    </h5>
                    <p class="card-text">
                        <?php echo substr(htmlspecialchars($product['description']), 0, 100).'...'; ?>
                    </p>
                    <p class="card-text">
                        <strong>Price: $<?php echo number_format($product['price'], 2); ?></strong>
                    </p>
                    <p class="card-text">
                        <small class="text-muted">Category: <?php echo htmlspecialchars($product['category_name']); ?></small>
                    </p>
                    <?php if (is_logged_in()) { ?>
                        <form method="post" action="index.php?page=home">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="add_to_cart" value="1">
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    <?php } else { ?>
                        <a href="index.php?page=login" class="btn btn-primary">Login to Buy</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div> 