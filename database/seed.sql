USE ecommerce;

-- Insert default admin user (password: admin123)
INSERT INTO users (email, password, type) 
VALUES ('admin@gmail.com', '$2y$10$8K1p/a4SWE6j5/GOOoMgCOzF9TJVZKp1qz.vsv6bqWL9yHk7WKjie', 'admin');
-- Insert sample categories
INSERT INTO categories (name) VALUES 
('T-shirts'),
('Pants'),
('Handbags'),
('Shoes'),
('Salwar Suits'),
('Lingerie');

-- Insert sample products
INSERT INTO products (name, category_id, description, price, image) VALUES 
('Cotton T-shirt', 1, 'Comfortable clothing cotton t-shirt', 19.99, '/assets/products/image1.jpg'),
('Jeans', 2, 'Comfortable clothing jeans', 29.99, '/assets/products/image2.jpg'),
('Handbag', 3, 'Stylish handbag for everyday use', 79.99, '/assets/products/image3.jpg'),
('Shoes', 4, 'Comfortable and durable running shoes', 59.99, '/assets/products/image4.jpg'),
('Salwar Suit', 5, 'Comfortable and elegant salwar suit', 49.99, '/assets/products/image5.jpg'),
('Lingerie', 6, 'Comfortable and elegant lingerie set', 49.99, '/assets/products/image6.jpg'),
('T-shirt', 1, 'Comfortable clothing cotton t-shirt', 19.99, '/assets/products/image1.jpg'),
('Pants', 2, 'Comfortable clothing pants', 29.99, '/assets/products/image2.jpg'),
('Handbag', 3, 'Stylish handbag for everyday use', 79.99, '/assets/products/image3.jpg'),
('Shoes', 4, 'Comfortable and durable running shoes', 59.99, '/assets/products/image4.jpg'),
('Salwar Suit', 5, 'Comfortable and elegant salwar suit', 49.99, '/assets/products/image5.jpg'),
('Lingerie', 6, 'Comfortable and elegant lingerie set', 49.99, '/assets/products/image6.jpg');