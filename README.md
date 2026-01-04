# ☕ Coffee Shop E-Commerce Website

A complete, production-ready full-stack PHP e-commerce application for coffee shops with customer ordering, QR code table ordering, reservations system, and comprehensive admin panel.

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## ✨ Features

### Customer Portal
- 🔐 User registration & authentication
- 📋 Menu browsing with category filtering (Coffee, Food, Desserts)
- 🛒 Shopping cart management
- 📦 Multiple order types: Takeaway, Delivery, Dine-in
- 📱 QR code table ordering
- 📅 Table reservations with real-time availability
- 👤 Account dashboard with order & reservation history

### Admin Panel
- 📊 Admin dashboard
- 🍽️ Menu management (Add, Edit, Delete items with image uploads)
- 📝 Order management (Approve, Reject, Update status)
- 🪑 Reservation management (Accept, Decline)
- 👥 Customer management

### Technical Highlights
- 🏗️ MVC Architecture
- 🔒 Secure authentication (Bcrypt hashing)
- 🛡️ CSRF protection
- 💉 SQL injection prevention (Prepared statements)
- 📱 Fully responsive design
- ♿ Accessibility compliant (WCAG AA)

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | PHP 7.4+ |
| Database | MySQL 5.7+ |
| Frontend | HTML5, CSS3 |
| Architecture | MVC Pattern |
| Server | Apache/Nginx |

## 📁 Project Structure

```
coffee-shop/
├── app/
│   ├── controllers/     # 12 request handlers
│   ├── models/          # 9 data models
│   └── views/           # 30+ templates
├── config/
│   ├── database.php     # DB connection
│   ├── constants.php    # App constants
│   └── config.php       # General config
├── helpers/
│   ├── SecurityHelper.php
│   ├── ValidationHelper.php
│   ├── SessionHelper.php
│   └── ImageHelper.php
├── database/
│   └── schema.sql       # Database schema
└── public/
    ├── index.php        # Entry point
    ├── css/             # Stylesheets
    ├── images/          # Static assets
    └── uploads/         # User uploads
```

## 🚀 Quick Start

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/coffee-shop.git
   cd coffee-shop
   ```

2. **Create database**
   ```bash
   mysql -u root -p < database/schema.sql
   ```

3. **Configure database connection**
   
   Edit `config/database.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'coffee_shop');
   ```

4. **Set file permissions**
   ```bash
   chmod 755 public/uploads/
   ```

5. **Access the application**
   ```
   http://localhost/coffee-shop/public/index.php
   ```

## 🔑 Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@coffeeshop.com | admin123 |
| Customer | Register new account | - |

> ⚠️ **Important**: Change admin password immediately in production!

## 📊 Database Schema

| Table | Description |
|-------|-------------|
| `customers` | Customer accounts |
| `admin_users` | Admin accounts |
| `menu_items` | Menu items with categories |
| `tables` | Restaurant tables |
| `orders` | Customer orders |
| `order_items` | Order line items |
| `reservations` | Table reservations |

## 🖼️ Screenshots

<details>
<summary>Click to view screenshots</summary>

### Home Page
*Add your screenshot here*

### Menu Page
*Add your screenshot here*

### Admin Dashboard
*Add your screenshot here*

</details>

## 🔒 Security Features

- ✅ Bcrypt password hashing
- ✅ CSRF token protection
- ✅ Prepared statements (SQL injection prevention)
- ✅ Input validation & sanitization
- ✅ Output escaping (XSS prevention)
- ✅ Secure session management
- ✅ Role-based access control

## 📱 Responsive Design

Fully responsive across all devices:
- 📱 Mobile (320px+)
- 📱 Tablet (768px+)
- 💻 Desktop (1200px+)

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Built with ❤️ for coffee lovers
- Icons from [your icon source]
- Inspired by modern coffee shop experiences

---

<p align="center">
  Made with ☕ and PHP
</p>
