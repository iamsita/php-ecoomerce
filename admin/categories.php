<?php
if (!is_admin()) {
    header('Location: index.php');
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_category'])) {
        if (add_category($_POST['name'])) {
            $message = "Category added successfully";
        }
    } elseif (isset($_POST['edit_category'])) {
        if (update_category($_POST['id'], $_POST['name'])) {
            $message = "Category updated successfully";
        }
    }
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (delete_category($_GET['delete'])) {
        $message = "Category deleted successfully";
    }
}
?>

<div class="card">
    <div class="card-header">
        <h2>Manage Categories</h2>
    </div>
    <div class="card-body">
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Category Name" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (get_categories() as $category): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td>
                        <a href="?page=admin&admin_page=categories&action=edit&id=<?php echo $category['id']; ?>" 
                           class="btn btn-sm btn-primary">Edit</a>
                        <a href="?page=admin&admin_page=categories&delete=<?php echo $category['id']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div> 