<?php
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $user_data = [
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
    ];
    // Validate input
    $errors = validate_user_data($user_data);

    // If no errors, try to register
    if (empty($errors)) {
        if (register_user($user_data)) {
            $success = true;
        } else {
            $errors['general'] = 'Registration failed. Email might already exist.';
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Register</h3>
            </div>
            <div class="card-body">
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        Registration successful! You can now <a href="index.php?page=login">login</a>.
                    </div>
                <?php else: ?>
                    <?php if (isset($errors['general'])): ?>
                        <div class="alert alert-danger"><?php echo $errors['general']; ?></div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label>Email*</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="text-danger"><?php echo $errors['email']; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label>Password*</label>
                            <input type="password" name="password" class="form-control" required>
                            <?php if (isset($errors['password'])): ?>
                                <div class="text-danger"><?php echo $errors['password']; ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Register</button>
                        <a href="index.php?page=login" class="btn btn-link">Already have an account? Login</a>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> 