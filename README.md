# 🗞️ News Platform – Laravel 10

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1-blue?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![License](https://img.shields.io/github/license/IbrahimAhmedKhashaba/news)](LICENSE)
[![Issues](https://img.shields.io/github/issues/IbrahimAhmedKhashaba/news)](https://github.com/IbrahimAhmedKhashaba/news/issues)
[![Stars](https://img.shields.io/github/stars/IbrahimAhmedKhashaba/news?style=social)](https://github.com/IbrahimAhmedKhashaba/news/stargazers)

A Laravel-based news publishing platform that allows users to register, write, and manage articles through an interactive dashboard. Admins can review, edit, and control all content. The app supports real-time notifications and has a mobile-friendly interface.

---

## 🚀 Features

- User & Admin Authentication
- Social Login via Facebook & Google (OAuth)
- Article Creation with Rich Text Editor
- Admin Dashboard with Article Control
- RESTful API Integration
- Real-time Notifications with Pusher
- Role-Based Access (Gates & Policies)
- Livewire Components for Dynamic UI
- Redis (via Predis) for Caching & Sessions
- Mailtrap Integration for Email Testing
- Responsive Design

---

## 🛠️ Built With

- **Laravel 10**
- **PHP 8+**
- **MySQL**
- **Livewire**
- **Blade Templates**
- **Pusher**
- **Bootstrap**
- **jQuery / Ajax**
- **Git & GitHub**

---

## 📦 Installation

```bash
git clone https://github.com/IbrahimAhmedKhashaba/news.git
cd news
composer install
cp .env.example .env
php artisan key:generate

# Set your DB, Mailtrap, Socialite, Redis, and Pusher credentials in your .env

php artisan migrate
php artisan db:seed
php artisan serve

---

## To access the admin dashboard, you can use the following demo credentials:

- **Email:** ibrahim@admin.com  
- **Password:** 789789789

---

## 👤 User Access Options

- 📝 **You can register manually** as a normal user.
- 🔗 **You can also log in using your Facebook or Gmail account** via social login integration (OAuth).

---

## 📬 API Documentation (Postman)

Want to test the API live? (for site)

👉 [Open Postman Documentation](https://documenter.getpostman.com/view/40282253/2sAYk7S4LM)

You can import it directly in Postman or use it online.

---

📬 Contact
For questions or feedback, feel free to reach me on:

💼 LinkedIn: https://www.linkedin.com/in/ibrahim-khashaba-9167a323b/

📧 Email: ibrahimahmedkhashaba@gmail.com

