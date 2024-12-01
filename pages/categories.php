<?php
// Get all categories
$categories = get_categories();

// Add after getting categories
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Add before the categories grid
include 'includes/search_bar.php';

// Update categories query
$categories = $search_query ? search_categories($search_query) : get_categories();
?>

<div class="row">
    <?php foreach ($categories as $category): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                    <?php if ($category['description']): ?>
                        <p class="card-text"><?php echo htmlspecialchars($category['description']); ?></p>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <?php
                        // Get count of products in this category
                        $products_count = get_category_products_count($category['id']);
                        ?>
                        <small class="text-muted"><?php echo $products_count; ?> products</small>
                        <a href="index.php?page=products&category=<?php echo $category['id']; ?>" 
                           class="btn btn-primary">View Products</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if (empty($categories)): ?>
    <div class="alert alert-info">
        No categories found.
    </div>
<?php endif; ?> 