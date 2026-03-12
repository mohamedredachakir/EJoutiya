# Plan d'Implémentation Backend - EJoutiya

Ce document détaille les migrations, modèles, relations, contrôleurs et routes nécessaires pour le projet EJoutiya.

## 1. Migrations & Modèles

### User (Table: `users`)
- **Champs:** `name`, `email`, `password`, `role` (enum: client, vendor, admin), `profile_image`.
- **Modèle:** `User.php`

### Store (Table: `stores`)
- **Champs:** `vendor_id` (FK), `name`, `slug` (unique), `description`, `logo`, `banner`, `is_active` (boolean).
- **Modèle:** `Store.php`

### Product (Table: `products`)
- **Champs:** `store_id` (FK), `category_id` (FK - optionnel), `name`, `slug`, `description`, `price` (decimal), `stock` (integer), `image`, `is_active`.
- **Modèle:** `Product.php`

### Order (Table: `orders`)
- **Champs:** `client_id` (FK), `total_price`, `status` (pending, paid, shipped, delivered, cancelled), `payment_method` (COD, Stripe, PayPal), `shipping_address`.
- **Modèle:** `Order.php`

### OrderItem (Table: `order_items`)
- **Champs:** `order_id` (FK), `product_id` (FK), `quantity`, `price` (at time of purchase).
- **Modèle:** `OrderItem.php`

### CartItem (Table: `cart_items`)
- **Champs:** `client_id` (FK), `product_id` (FK), `quantity`.
- **Modèle:** `CartItem.php`

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
