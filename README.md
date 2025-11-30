# Attendify - Smart Attendance Management System

A modern, role-based attendance management system built with Laravel 11, featuring real-time analytics, notifications, and a beautiful dark mode interface.

## 🚀 Features

- **Role-Based Access Control** (Admin, Teacher, Student)
- **Real-Time Dashboard** with Chart.js analytics
- **Modern UI** with Tailwind CSS 4 & Dark Mode
- **Attendance Management** with multiple marking options
- **Notification System** with real-time updates
- **Reports & Export** functionality
- **Responsive Design** for all devices

## 🛠️ Tech Stack

- **Backend**: Laravel 11 with Breeze authentication
- **Frontend**: Blade templates, Alpine.js, Tailwind CSS 4
- **Database**: PostgreSQL 18
- **Charts**: Chart.js for analytics
- **Deployment**: Render.com ready

## 📋 Requirements

- PHP 8.2+
- Composer
- Node.js & npm
- PostgreSQL 18

## 🔧 Installation

1. **Clone the repository**
```bash
git clone <repository-url>
cd attendify
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database**
Update `.env` with your PostgreSQL credentials:
```env
DB_CONNECTION=pgsql
DB_HOST=your-host
DB_PORT=5432
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

5. **Run migrations and seeders**
```bash
php artisan migrate
php artisan db:seed
```

6. **Build assets**
```bash
npm run build
```

7. **Start the server**
```bash
php artisan serve
```

## 👥 Demo Accounts

- **Admin**: admin@attendify.com / password
- **Teacher**: john@attendify.com / password
- **Student**: alice@attendify.com / password

## 🚀 Deployment on Render

1. **Set environment variables** in Render dashboard:
   - `DATABASE_HOST`: Your PostgreSQL host
   - `DATABASE_PORT`: 5432
   - `DATABASE_NAME`: Your database name
   - `DATABASE_USER`: Your database user
   - `DATABASE_PASSWORD`: Your database password

2. **Deploy** using the included `render.yaml` configuration

## 📝 License

This project is open-sourced software licensed under the MIT license.

## 👨‍💻 Developer

Developed with ❤️ by [Saurabh Lode](https://github.com/Saurabhlode)