<?php
if (!is_admin()) {
    header('Location: index.php');
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$message = '';

// Get category for editing
$edit_category = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $edit_category = get_category($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_category'])) {
        $name = $_POST['name'];
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        if (add_category($name, $slug)) {
            $message = "Category added successfully";
        }
    } elseif (isset($_POST['edit_category'])) {
        $name = $_POST['name'];
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        if (update_category($_POST['id'], $name, $slug)) {
            header('Location: index.php?page=admin&admin_page=categories');
            exit;
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
        <h2><?php echo $action === 'edit' ? 'Edit Category' : 'Manage Categories'; ?></h2>
    </div>
    <div class="card-body">
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post" class="mb-4">
            <?php if ($edit_category): ?>
                <input type="hidden" name="id" value="<?php echo $edit_category['id']; ?>">
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Category Name</label>
                        <input type="text" name="name" class="form-control" 
                               value="<?php echo $edit_category ? htmlspecialchars($edit_category['name']) : ''; ?>" 
                               placeholder="Category Name" required>
                    </div>
                    <button type="submit" 
                            name="<?php echo $edit_category ? 'edit_category' : 'add_category'; ?>" 
                            class="btn btn-primary">
                        <?php echo $edit_category ? 'Update Category' : 'Add Category'; ?>
                    </button>
                    <?php if ($edit_category): ?>
                        <a href="index.php?page=admin&admin_page=categories" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <?php if ($action !== 'edit'): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (get_categories() as $category): ?>
                    <tr>
                        <td><?php echo $category['id']; ?></td>
                        <td><?php echo htmlspecialchars($category['name']); ?></td>
                        <td><?php echo htmlspecialchars($category['slug']); ?></td>
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
        <?php endif; ?>
    </div>
</div> 