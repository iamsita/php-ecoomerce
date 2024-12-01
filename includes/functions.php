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
            'quantity' => $quantity
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

function login_user($username, $password) {
    global $db;
    
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type'];
        return true;
    }
    return false;
}

function register_user($username, $password, $email) {
    global $db;
    
    try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashed_password, $email]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function add_category($name) {
    global $db;
    $stmt = $db->prepare("INSERT INTO categories (name) VALUES (?)");
    return $stmt->execute([$name]);
}

function update_category($id, $name) {
    global $db;
    $stmt = $db->prepare("UPDATE categories SET name = ? WHERE id = ?");
    return $stmt->execute([$name, $id]);
}

function delete_category($id) {
    global $db;
    $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
    return $stmt->execute([$id]);
}

function add_product($name, $category_id, $description, $price, $image) {
    global $db;
    $stmt = $db->prepare("INSERT INTO products (name, category_id, description, price, image) 
                         VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$name, $category_id, $description, $price, $image]);
}

function update_product($id, $name, $category_id, $description, $price, $image) {
    global $db;
    $stmt = $db->prepare("UPDATE products SET name = ?, category_id = ?, description = ?, 
                         price = ?, image = ? WHERE id = ?");
    return $stmt->execute([$name, $category_id, $description, $price, $image, $id]);
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