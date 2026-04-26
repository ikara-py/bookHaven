# BookHaven

**BookHaven** is a modern, full-featured multi-vendor bookstore marketplace built with Laravel. It provides a seamless experience for buyers to discover and purchase books, while offering sellers a robust platform to manage their inventory and sales.

---

## Key Features

### User Management & Roles
- **Multi-Role System**: Distinct workflows for **Buyers**, **Sellers**, and **Administrators**.
- **Secure Authentication**: Built-in registration, login, and profile management.
- **Seller Onboarding**: Sellers can request profiles and must be approved by an administrator before listing products.

### Buyer Experience
- **Advanced Browsing**: Explore books categorized by genre or author.
- **Shopping Cart**: Dynamic cart management with support for **Coupons** (Fixed/Percentage discounts).
- **Wishlist**: Save favorite books for future purchases.
- **Order Tracking**: Comprehensive order history with real-time status updates (Pending, Shipped, Delivered, etc.).
- **Digital Fulfillment**: Secure download mechanism for eBook purchases.
- **Reviews & Ratings**: Share feedback and rate books after purchase.

### Seller Portal
- **Inventory Management**: Create and manage book listings (Title, Author, Category, ISBN, Stock, Physical/Digital types).
- **Seller Dashboard**: Visual overview of sales performance and book statistics.
- **Order Fulfillment**: Track and update the status of specific order items assigned to the seller.

### Administrative Control
- **Admin Dashboard**: Global statistics and system overview.
- **Moderation**: Approve/reject new sellers and manage book listings.
- **Coupon System**: Create and manage promotional codes with usage limits and expiration dates.
- **User Governance**: Update roles, statuses, and manage the platform's user base.

---

## Technology Stack

- **Backend**: [Laravel 12](https://laravel.com/) (PHP)
- **Frontend**: [Tailwind CSS 4.0](https://tailwindcss.com/), Blade Templates
- **Database**: MySQL
- **Asset Management**: [Vite](https://vitejs.dev/)
- **Payments**: [Stripe Integration](https://stripe.com/)
- **Authentication**: Laravel Session-based Auth

---

## Installation & Setup

Follow these steps to get the project running locally:

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

### 4. Database Setup
Run the migrations and seeders to populate the database:
```bash
php artisan migrate --seed
```

### 5. Build Assets
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
│   │   ├── Admin/      # Admin moderation & management
│   │   ├── Seller/     # Seller dashboard & book management
│   │   └── Buyer/      # Browsing, Cart, Wishlist, Orders
│   └── Middleware/     # Role-based access control
├── Models/             # Database relationships & logic
database/
└── migrations/         # Schema definitions
```

---

## License
This project is open-source and available under the [MIT License](LICENSE).
