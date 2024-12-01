USE ecommerce;

-- Insert default admin user (password: admin123)
INSERT INTO users (email, password, type, username) 
VALUES ('admin@example.com', '$2y$10$8K1p/a4SWE6j5/GOOoMgCOzF9TJVZKp1qz.vsv6bqWL9yHk7WKjie', 'admin', 'admin');

-- Insert sample categories with slugs
INSERT INTO categories (name, slug, description) VALUES 
('Clothing & Beauty', 'clothing-beauty', 'Fashion, apparel, and beauty products'),
('Makeup', 'makeup', 'Cosmetics and makeup products'),
('Jewelry', 'jewelry', 'Jewelry and accessories'),
('Handbags', 'handbags', 'Handbags and purses'),
('Shoes', 'shoes', 'Footwear for all occasions'),
('Skincare', 'skincare', 'Skincare products and treatments'),
('Haircare', 'haircare', 'Haircare products and accessories'),
('Fragrances', 'fragrances', 'Perfumes and fragrances'),
('Lingerie', 'lingerie', 'Lingerie and intimate wear');

-- Insert sample products with slugs and stock
INSERT INTO products (name, slug, category_id, description, price, stock_quantity, image) VALUES 
('Smartphone', 'smartphone', 1, 'Latest smartphone with amazing features', 699.99, 10, '/assets/products/image1.jpg'),
('Laptop', 'laptop', 1, 'Powerful laptop for work and gaming', 999.99, 5, '/assets/products/image2.jpg'),
('Cotton T-shirt', 'cotton-t-shirt', 2, 'Comfortable cotton t-shirt', 19.99, 50, '/assets/products/image3.jpg'),
('Novel', 'novel', 3, 'Bestselling fiction novel', 14.99, 20, '/assets/products/image4.jpg'),
('Coffee Maker', 'coffee-maker', 4, 'Automatic coffee maker with timer', 79.99, 15, '/assets/products/image5.jpg'),
('Tablet', 'tablet', 1, 'Lightweight tablet perfect for entertainment', 299.99, 8, '/assets/products/image6.jpg'),
('Wireless Earbuds', 'wireless-earbuds', 1, 'Premium wireless earbuds with noise cancellation', 149.99, 25, '/assets/products/image7.jpg'),
('Smart Watch', 'smart-watch', 1, 'Feature-rich smartwatch with health tracking', 199.99, 12, '/assets/products/image8.jpg'),
('Bluetooth Speaker', 'bluetooth-speaker', 1, 'Portable speaker with amazing sound quality', 89.99, 18, '/assets/products/image9.jpg'),
('Gaming Console', 'gaming-console', 1, 'Next-gen gaming console for immersive gaming', 499.99, 7, '/assets/products/image10.jpg'),
('Denim Jeans', 'denim-jeans', 2, 'Classic fit denim jeans', 49.99, 40, '/assets/products/image11.jpg'),
('Formal Dress Shirt', 'formal-dress-shirt', 2, 'Formal dress shirt for professional look', 39.99, 30, '/assets/products/image12.jpg'),
('Winter Sweater', 'winter-sweater', 2, 'Warm winter sweater', 45.99, 25, '/assets/products/image13.jpg'),
('Casual Jacket', 'casual-jacket', 2, 'Stylish casual jacket', 79.99, 20, '/assets/products/image14.jpg'),
('Summer Shorts', 'summer-shorts', 2, 'Comfortable summer shorts', 24.99, 35, '/assets/products/image15.jpg'),
('Mystery Book', 'mystery-book', 3, 'Thrilling mystery novel', 16.99, 25, '/assets/products/image16.jpg'),
('Cookbook', 'cookbook', 3, 'Collection of gourmet recipes', 29.99, 15, '/assets/products/image17.jpg'),
('Science Fiction', 'science-fiction', 3, 'Epic sci-fi adventure', 19.99, 22, '/assets/products/image18.jpg'),
('Biography', 'biography', 3, 'Inspiring life story', 24.99, 18, '/assets/products/image19.jpg'),
('Self Help Book', 'self-help-book', 3, 'Guide to personal development', 21.99, 28, '/assets/products/image20.jpg'),
('Blender', 'blender', 4, 'High-speed blender for smoothies', 69.99, 14, '/assets/products/image21.jpg'),
('Toaster', 'toaster', 4, '4-slice toaster with multiple settings', 49.99, 20, '/assets/products/image22.jpg'),
('Rice Cooker', 'rice-cooker', 4, 'Automatic rice cooker with steamer', 59.99, 16, '/assets/products/image23.jpg'),
('Air Fryer', 'air-fryer', 4, 'Digital air fryer for healthy cooking', 129.99, 10, '/assets/products/image24.jpg'),
('Food Processor', 'food-processor', 4, 'Versatile food processor', 89.99, 12, '/assets/products/image25.jpg'),
('Wireless Mouse', 'wireless-mouse', 1, 'Ergonomic wireless mouse', 29.99, 30, '/assets/products/image26.jpg'),
('Keyboard', 'keyboard', 1, 'Mechanical gaming keyboard', 89.99, 15, '/assets/products/image27.jpg'),
('Monitor', 'monitor', 1, '27-inch 4K monitor', 299.99, 8, '/assets/products/image28.jpg'),
('Evening Dress', 'evening-dress', 2, 'Elegant evening dress', 89.99, 15, '/assets/products/image29.jpg'),
('Athletic Sneakers', 'athletic-sneakers', 2, 'Comfortable athletic sneakers', 69.99, 25, '/assets/products/image30.jpg'),
('History Book', 'history-book', 3, 'Comprehensive world history', 34.99, 20, '/assets/products/image31.jpg'),
('Poetry Collection', 'poetry-collection', 3, 'Classic poetry anthology', 19.99, 15, '/assets/products/image32.jpg'),
('Microwave', 'microwave', 4, 'Digital microwave oven', 149.99, 10, '/assets/products/image33.jpg'),
('Stand Mixer', 'stand-mixer', 4, 'Professional stand mixer', 249.99, 8, '/assets/products/image34.jpg'),
('External Hard Drive', 'external-hard-drive', 1, '2TB portable hard drive', 79.99, 20, '/assets/products/image35.jpg'),
('Webcam', 'webcam', 1, 'HD webcam for video calls', 59.99, 25, '/assets/products/image36.jpg'),
('Pullover Hoodie', 'pullover-hoodie', 2, 'Casual pullover hoodie', 34.99, 30, '/assets/products/image37.jpg'),
('University Textbook', 'university-textbook', 3, 'University textbook', 79.99, 12, '/assets/products/image38.jpg'),
('Electric Kettle', 'electric-kettle', 4, 'Electric kettle with temperature control', 39.99, 18, '/assets/products/image39.jpg'),
('Multi-function Pressure Cooker', 'multi-function-pressure-cooker', 4, 'Multi-function pressure cooker', 119.99, 10, '/assets/products/image40.jpg');