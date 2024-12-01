USE ecommerce;

-- Insert default admin user (password: admin123)
INSERT INTO users (email, password, type, username) 
VALUES ('admin@example.com', '$2y$10$8K1p/a4SWE6j5/GOOoMgCOzF9TJVZKp1qz.vsv6bqWL9yHk7WKjie', 'admin', 'admin');

-- Insert sample categories with slugs
INSERT INTO categories (name, slug) VALUES 
('Clothing & Beauty', 'clothing-beauty'),
('Makeup', 'makeup'),
('Jewelry', 'jewelry'),
('Handbags', 'handbags'),
('Shoes', 'shoes'),
('Skincare', 'skincare'),
('Haircare', 'haircare'),
('Fragrances', 'fragrances'),
('Lingerie', 'lingerie');

-- Insert sample products with slugs and stock
INSERT INTO products (name, slug, category_id, description, price, image) VALUES 
('Cotton T-shirt', 'cotton-t-shirt', 1, 'Comfortable clothing cotton t-shirt', 19.99, '/assets/products/image3.jpg'),
('Makeup Kit', 'makeup-kit', 2, 'Complete makeup kit for all occasions', 49.99, '/assets/products/image41.jpg'),
('Jewelry Set', 'jewelry-set', 3, 'Elegant jewelry set for special events', 99.99, '/assets/products/image42.jpg'),
('Handbag', 'handbag', 4, 'Stylish handbag for everyday use', 79.99, '/assets/products/image43.jpg'),
('Running Shoes', 'running-shoes', 5, 'Comfortable and durable running shoes', 59.99, '/assets/products/image44.jpg'),
('Skincare Set', 'skincare-set', 6, 'Complete skincare set for glowing skin', 89.99, '/assets/products/image45.jpg'),
('Haircare Kit', 'haircare-kit', 7, 'Essential haircare kit for healthy hair', 39.99, '/assets/products/image46.jpg'),
('Fragrance', 'fragrance', 8, 'Long-lasting fragrance for daily wear', 69.99, '/assets/products/image47.jpg'),
('Lingerie Set', 'lingerie-set', 9, 'Comfortable and elegant lingerie set', 49.99, '/assets/products/image48.jpg');