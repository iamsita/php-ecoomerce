<?php
function get_products($limit = null) {
    global $db;
    $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id";
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }
    $stmt = $db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_product($id) {
    global $db;
    $stmt = $db->prepare("SELECT p.*, c.name as category_name 
                         FROM products p 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         WHERE p.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_categories() {
    global $db;
    $stmt = $db->query("SELECT * FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function add_to_cart($product_id, $quantity = 1) {
    if (!is_logged_in()) {
        return false;
    }

    $product = get_product($product_id);
    if (!$product) return false;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'image' => $product['image']
        ];
    }
    return true;
}

function get_cart_total() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

function create_order($user_id) {
    global $db;
    
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return false;
    }

    try {
        $db->beginTransaction();

        // Create order
        $stmt = $db->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
        $total = get_cart_total();
        $stmt->execute([$user_id, $total]);
        $order_id = $db->lastInsertId();

        // Create order items
        $stmt = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($_SESSION['cart'] as $product_id => $item) {
            $stmt->execute([$order_id, $product_id, $item['quantity'], $item['price']]);
        }

        $db->commit();
        unset($_SESSION['cart']);
        return $order_id;
    } catch (Exception $e) {
        $db->rollBack();
        return false;
    }
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

function login_user($email, $password) {
    global $db;
    
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_type'] = $user['type'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    return false;
}

function register_user($data) {
    global $db;
    
    try {
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (email, password, username) VALUES (?, ?, ?)");
        $stmt->execute([
            $data['email'],
            $hashed_password,
            $data['username'] ?? null
        ]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function add_category($name, $slug) {
    global $db;
    $stmt = $db->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
    return $stmt->execute([$name, $slug]);
}

function update_category($id, $name, $slug) {
    global $db;
    $stmt = $db->prepare("UPDATE categories SET name = ?, slug = ? WHERE id = ?");
    return $stmt->execute([$name, $slug, $id]);
}

function delete_category($id) {
    global $db;
    $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
    return $stmt->execute([$id]);
}

function add_product($name, $slug, $category_id, $description, $price, $image) {
    global $db;
    $stmt = $db->prepare("INSERT INTO products (name, slug, category_id, description, price, image) 
                         VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$name, $slug, $category_id, $description, $price, $image]);
}

function update_product($id, $name, $slug, $category_id, $description, $price, $image) {
    global $db;
    $stmt = $db->prepare("UPDATE products SET name = ?, slug = ?, category_id = ?, description = ?, 
                         price = ?, image = ? WHERE id = ?");
    return $stmt->execute([$name, $slug, $category_id, $description, $price, $image, $id]);
}

function delete_product($id) {
    global $db;
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([$id]);
}

function get_all_orders() {
    global $db;
    $stmt = $db->query("SELECT o.*, u.username FROM orders o 
                        JOIN users u ON o.user_id = u.id 
                        ORDER BY o.created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function update_order_status($order_id, $status) {
    global $db;
    $stmt = $db->prepare("UPDATE orders SET status = ? WHERE id = ?");
    return $stmt->execute([$status, $order_id]);
}

function get_products_by_category($category_id) {
    global $db;
    $stmt = $db->prepare("SELECT p.*, c.name as category_name 
                         FROM products p 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         WHERE p.category_id = ?");
    $stmt->execute([$category_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function validate_user_data($data) {
    $errors = [];
    
    if (empty($data['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    
    if (empty($data['password'])) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($data['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }
    
    return $errors;
}

function get_status_color($status) {
    switch ($status) {
        case 'pending':
            return 'warning';
        case 'processing':
            return 'info';
        case 'shipped':
            return 'primary';
        case 'delivered':
            return 'success';
        case 'cancelled':
            return 'danger';
        default:
            return 'secondary';
    }
}

function handle_image_upload($image_file) {
    if (!$image_file || $image_file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    // Set the directory path relative to document root
    $upload_dir = "assets/products/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Get file extension
    $ext = strtolower(pathinfo($image_file['name'], PATHINFO_EXTENSION));
    
    // Only allow certain file types
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($ext, $allowed_types)) {
        return null;
    }
    
    // Generate simple filename: product_timestamp.extension
    $filename = 'product_' . time() . '.' . $ext;
    
    // Full server path for moving the file
    $target_path = $upload_dir . $filename;
    
    // URL path for database storage
    $db_path = '/' . $target_path; // Add leading slash for URL path

    if (move_uploaded_file($image_file['tmp_name'], $target_path)) {
        return $db_path; // Return URL path starting with /assets/...
    }

    return null;
}

function get_category($id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}