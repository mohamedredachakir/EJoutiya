# Plan d'Implémentation Backend - EJoutiya

Ce document détaille les migrations, modèles, relations, contrôleurs et routes nécessaires pour le projet EJoutiya.

## 1. Migrations & Modèles

### 1.1 User (Table: `users`)
- **Fichier:** `0001_01_01_000000_create_users_table.php` (Défaut Laravel)
- **Modèle:** `User.php`
- **Propriétés:**
    - `id` (Primary Key)
    - `name` (string)
    - `email` (string, unique)
    - `password` (string)
    - `role` (enum: 'client', 'vendor', 'admin', default: 'client')
    - `profile_image` (string, nullable)
    - `email_verified_at` (timestamp, nullable)
    - `remember_token` (string, nullable)
    - `timestamps`

### 1.2 Store (Table: `stores`)
- **Fichier:** `2024_03_12_000001_create_stores_table.php`
- **Modèle:** `Store.php`
- **Propriétés:**
    - `id` (Primary Key)
    - `vendor_id` (foreignId -> users, constrained, onDelete cascade)
    - `name` (string)
    - `slug` (string, unique)
    - `description` (text, nullable)
    - `logo` (string, nullable)
    - `banner` (string, nullable)
    - `is_active` (boolean, default: true)
    - `timestamps`

### 1.3 Product (Table: `products`)
- **Fichier:** `2024_03_12_000002_create_products_table.php`
- **Modèle:** `Product.php`
- **Propriétés:**
    - `id` (Primary Key)
    - `store_id` (foreignId -> stores, constrained, onDelete cascade)
    - `name` (string)
    - `slug` (string, unique)
    - `description` (text, nullable)
    - `price` (decimal, 10, 2)
    - `stock` (integer, default: 0)
    - `image` (string, nullable)
    - `is_active` (boolean, default: true)
    - `timestamps`

### 1.4 Order (Table: `orders`)
- **Fichier:** `2024_03_12_000003_create_orders_table.php`
- **Modèle:** `Order.php`
- **Propriétés:**
    - `id` (Primary Key)
    - `client_id` (foreignId -> users, constrained, onDelete cascade)
    - `total_price` (decimal, 10, 2)
    - `status` (enum: 'pending', 'paid', 'shipped', 'delivered', 'cancelled', default: 'pending')
    - `payment_method` (string: 'COD', 'Stripe', 'PayPal')
    - `shipping_address` (text)
    - `timestamps`

### 1.5 OrderItem (Table: `order_items`)
- **Fichier:** `2024_03_12_000004_create_order_items_table.php`
- **Modèle:** `OrderItem.php`
- **Propriétés:**
    - `id` (Primary Key)
    - `order_id` (foreignId -> orders, constrained, onDelete cascade)
    - `product_id` (foreignId -> products, constrained)
    - `quantity` (integer)
    - `price` (decimal, 10, 2)
    - `timestamps`

### 1.6 CartItem (Table: `cart_items`)
- **Fichier:** `2024_03_12_000005_create_cart_items_table.php`
- **Modèle:** `CartItem.php`
- **Propriétés:**
    - `id` (Primary Key)
    - `client_id` (foreignId -> users, constrained, onDelete cascade)
    - `product_id` (foreignId -> products, constrained, onDelete cascade)
    - `quantity` (integer)
    - `timestamps`

---

## 2. Relations Eloquent

- **User:**
    - `hasMany(Store)` (pour les Vendors)
    - `hasMany(Order)` (pour les Clients)
    - `hasMany(CartItem)`
- **Store:**
    - `belongsTo(User, 'vendor_id')`
    - `hasMany(Product)`
- **Product:**
    - `belongsTo(Store)`
    - `hasMany(OrderItem)`
    - `hasMany(CartItem)`
- **Order:**
    - `belongsTo(User, 'client_id')`
    - `hasMany(OrderItem)`
- **OrderItem:**
    - `belongsTo(Order)`
    - `belongsTo(Product)`
- **CartItem:**
    - `belongsTo(User)`
    - `belongsTo(Product)`

---

## 3. Contrôleurs & Routes API

### Authentification (`AuthController`)
- `POST /api/register` -> `register()`
- `POST /api/login` -> `login()`
- `POST /api/logout` -> `logout()` (Sanctum)
- `GET /api/user` -> `profile()`

### Magasins Publics (`StoreController`)
- `GET /api/stores` -> `index()` (Liste tous les magasins)
- `GET /api/stores/{slug}` -> `show()` (Détails et produits d'un magasin)

### Produits Publics (`ProductController`)
- `GET /api/products` -> `index()` (Recherche/Filtres)
- `GET /api/products/{slug}` -> `show()`

### Panier (`CartController`)
- `GET /api/cart` -> `index()`
- `POST /api/cart` -> `store()`
- `PUT /api/cart/{id}` -> `update()`
- `DELETE /api/cart/{id}` -> `destroy()`

### Commandes (`OrderController`)
- `POST /api/orders` -> `checkout()`
- `GET /api/orders` -> `index()` (Historique client)
- `GET /api/orders/{id}` -> `show()`

### Espace Vendor (`Vendor/VendorController`)
- `GET /api/vendor/dashboard` -> Statistiques
- `GET/POST/PUT/DELETE /api/vendor/products` -> CRUD Produits
- `GET /api/vendor/orders` -> Commandes du magasin

### Espace Admin (`Admin/AdminController`)
- `GET /api/admin/users` -> Gestion utilisateurs
- `GET /api/admin/stores` -> Modération magasins
- `GET /api/admin/orders` -> Vue globale
