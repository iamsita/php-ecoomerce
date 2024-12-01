<?php
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (login_user($email, $password)) {
        // Redirect based on the intended destination or default to home
        $redirect = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'index.php';
        unset($_SESSION['redirect_after_login']); // Clear the stored redirect
        header('Location: ' . $redirect);
        exit;
    } else {
        $error = 'Invalid email or password';
    }
}

// Store the current page as redirect destination if it's not the login page
if (!isset($_SESSION['redirect_after_login']) && isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
    if (!strpos($referer, 'login') && !strpos($referer, 'register')) {
        $_SESSION['redirect_after_login'] = $referer;
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="index.php?page=register" class="btn btn-link">Create new account</a>
                </form>
            </div>
        </div>
    </div>
</div>