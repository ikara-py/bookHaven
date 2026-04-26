# BookHaven

BookHaven is a modern, full-featured multi-vendor bookstore marketplace built with Laravel. It provides a seamless experience for buyers to discover and purchase books, while offering sellers a robust platform to manage their inventory and sales.

---

## Key Features

### User Management & Roles

- Multi-Role System: Distinct workflows for Buyers, Sellers, and Administrators.
- Secure Authentication: Built-in registration, login, and profile management.
- Seller Onboarding: Sellers request a profile and must be approved by an administrator before listing products.

### Buyer Experience

- Advanced Browsing: Explore books by genre category or author, with full-text search across the catalog.
- Shopping Cart: Dynamic cart management with support for Coupons (fixed-amount and percentage discounts).
- Wishlist: Save favorite books for future purchases.
- Order Tracking: Comprehensive order history with real-time status updates (Pending, Shipped, Delivered) and buyer-initiated cancellation.
- Digital Fulfillment: Secure, purchase-gated download mechanism for eBook purchases.
- Reviews and Ratings: Share feedback and rate books after purchase.

### Seller Portal

- Inventory Management: Create and manage book listings (Title, Author, Category, ISBN, Language, Stock, Physical/Digital types, optional PDF for eBooks).
- Seller Dashboard: Visual overview of total listings, pending orders, total earnings, and recent sales activity.
- Order Fulfillment: Track and update the fulfillment status of order items assigned to the seller.

### Administrative Control

- Admin Dashboard: Global statistics including total users, sellers, books, orders, revenue, and pending approvals.
- Moderation: Approve new sellers, manage all book listings, and remove policy-violating reviews.
- Category Management: Full CRUD over book categories with support for hierarchical (parent/child) structures.
- Coupon System: Create and manage promotional codes with fixed or percentage discounts, minimum order amounts, usage limits, expiration dates, and active/inactive status.
- User Governance: Update roles, suspend or reactivate accounts, and manage the full platform user base.

---

## Technology Stack

- Backend: Laravel 12 (PHP 8.2+)
- Frontend: Tailwind CSS 4.0, Blade Templates
- Database: MySQL 8.0
- Asset Management: Vite 7
- Payments: Stripe (stripe/stripe-php SDK with webhook verification)
- Authentication: Laravel session-based auth with custom role middleware

---

## Installation & Setup

Follow these steps to get the project running locally.

### 1. Clone the repository

```bash
git clone https://github.com/ikara-py/bookHaven.git
cd bookHaven
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Configuration

Copy the `.env.example` file and configure your database and Stripe credentials:

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and set your `DB_*` values and the following Stripe keys:

```
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
```

### 4. Database Setup

Run the migrations and seeders to populate the database:

```bash
php artisan migrate --seed
```

### 5. Link Storage

Required for book cover images and eBook PDF downloads to be publicly accessible:

```bash
php artisan storage:link
```

### 6. Build Assets

```bash
npm run dev
# or for production
npm run build
```

---

## Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # User, book, order, category, coupon, review management
│   │   ├── Seller/         # Seller dashboard, book listings, order fulfillment
│   │   └── Buyer/          # Browsing, cart, wishlist, orders, reviews, downloads
│   ├── Middleware/          # RoleMiddleware, SellerApproved
│   └── Requests/           # Form validation (Auth, Book, Cart, Order, Coupon)
├── Models/                 # Eloquent models and relationships
├── Services/               # Business logic layer (Auth, Book, Cart, Order, Seller, Admin, etc.)
database/
└── migrations/             # Full schema definitions
routes/
└── web.php                 # All application routes
```

---

## License

This project is open-source and available under the [MIT License](LICENSE).
