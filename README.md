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
- **Unit Testing**

---

# 🧠 Real Use of Design Patterns in Laravel Projects – Ibrahim Khashaba

As a Laravel Back-End Developer, I apply several design patterns to write scalable, maintainable, and testable applications.  
Here’s how I used real design patterns in this project:

## 🔁 Repository Pattern  
Used to abstract and separate DB logic from controller logic.  
I created classes like `PostRepository` to handle all post-related queries. This allowed me to easily switch the data source, reuse queries, and simplify testing.

## 🧱 Factory Pattern  
Applied in Laravel using `ModelFactory` to generate fake data for seeding and testing.  
For example: `Post::factory()->count(10)->create();`  
It helped speed up tests and avoid repetition in creating test records.

## 🎯 Strategy Pattern  
Implemented in login systems where users can register using Facebook, Google, or manual forms.  

## 🔒 Singleton Pattern  
Observed in Laravel’s core (e.g., `DB`, `Auth`, `Config`) where only one instance of a service is used throughout the application.  
This ensures consistent shared state and efficient resource use.

## 👀 Observer Pattern  
Used Laravel Model Observers to automatically trigger notifications when a comment or contact form is submitted.  
It helped decouple the logic from controllers and centralize side-effects.

## 📚 Builder Pattern  
Laravel’s fluent query builder is a perfect example of this.  
I used it extensively for dynamic filtering, sorting, and pagination in dashboards and search results.

## 📦 Dependency Injection / IoC  
Used to inject repositories and services into controllers and jobs.  
It ensures loose coupling, improves testability, and promotes clean architecture.

## 🧪 Command Pattern  
Implemented using Laravel Artisan Commands and Jobs to encapsulate tasks like sending newsletters or notifications.  
Each action is placed in its own class, promoting reusability and testability.

## 🔁 Decorator Pattern  
Implemented using middleware layers in Laravel where each middleware wraps around the request and adds behavior (auth, log, throttle) without modifying core logic.

## 📡 Mediator Pattern  
Applied through Laravel Events & Listeners.  
Events like `NewCommentEvent` dispatch multiple listeners without them knowing about each other, promoting decoupled architecture.

## 🔀 Chain of Responsibility  
Clearly applied through middleware stack (auth → verified → admin check), where each layer decides whether to pass the request or return a response.

## 🧠 State Pattern  
Used in post status (active, inactive).  
Different behaviors (e.g., visibility, editability) are handled based on the post's current state.

## 🧱 Template Method Pattern  
Traits or base service classes provide a general logic skeleton (like `handleImage()`), while child classes or methods define specific behavior (e.g., upload path, resize).

## 👥 Facade Pattern  
Used Laravel’s facades like `Cache`, `Mail`, `DB`, which provide simple static interfaces over complex service classes.

## 🔐 Proxy Pattern  
When dealing with external APIs, I cached the results temporarily to avoid repeated calls — creating a proxy layer between the user and the actual API.

### 💬 These patterns helped me write professional Laravel applications that are easier to test, scale, and maintain in real-life projects.

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

