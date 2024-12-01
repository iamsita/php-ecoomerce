<?php
if (!is_admin()) {
    header('Location: index.php');
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_product']) || isset($_POST['edit_product'])) {
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = '';

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $image = $target_dir . time() . '_' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        }

        if (isset($_POST['add_product'])) {
            if (add_product($name, $category_id, $description, $price, $image)) {
                $message = "Product added successfully";
            }
        } elseif (isset($_POST['edit_product'])) {
            if (update_product($_POST['id'], $name, $category_id, $description, $price, $image)) {
                $message = "Product updated successfully";
            }
        }
    }
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (delete_product($_GET['delete'])) {
        $message = "Product deleted successfully";
    }
}
?>

<div class="card">
    <div class="card-header">
        <h2>Manage Products</h2>
    </div>
    <div class="card-body">
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Product Name" required>
                    </div>
                    <div class="mb-3">
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach (get_categories() as $category): ?>
                                <option value="<?php echo $category['id']; ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <textarea name="description" class="form-control" placeholder="Description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="number" name="price" class="form-control" placeholder="Price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="image" class="form-control">
                    </div>
                    <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (get_products() as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td>
                        <?php if ($product['image']): ?>
                            <img src="<?php echo $product['image']; ?>" alt="" style="width: 50px;">
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                    <td>
                        <a href="?page=admin&admin_page=products&action=edit&id=<?php echo $product['id']; ?>" 
                           class="btn btn-sm btn-primary">Edit</a>
                        <a href="?page=admin&admin_page=products&delete=<?php echo $product['id']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div> 