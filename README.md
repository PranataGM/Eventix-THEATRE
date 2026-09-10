# 🎟️ Event Management System

A professional, full-featured Event Management and Ticketing System built with **Laravel 11** and **FilamentPHP**. This application allows organizers to create events, manage dynamic ticket quotas, and seamlessly process payments using the **Midtrans Payment Gateway**.

## ✨ Features

### 🏢 Admin & Organizer Panel (Powered by Filament v3)
- **Role-Based Access Control (RBAC):** Distinct roles for `Super Admin`, `Organizer`, and `Scanner` using Spatie Permissions.
- **Event Management:** Create and manage events with date, time, location, and overall venue capacity.
- **Dynamic Ticket Quotas:** Create multiple ticket tiers (e.g., VIP, Regular). The system automatically validates that the sum of ticket quotas does not exceed the venue's overall capacity.
- **Real-Time Registration Tracking:** Monitor incoming registrations and payment statuses in an intuitive dashboard.

### 👥 User Facing Frontend (Tailwind CSS)
- **Modern UI:** Clean, responsive, and beautiful UI for discovering events and purchasing tickets.
- **Smart Quota System:** Real-time checking of remaining tickets. Automatically grays out and labels ticket tiers as "Sold Out" when capacity is reached.
- **Midtrans Payment Integration:** Fully integrated with Midtrans Snap API for secure, automated, and real-time payment verifications. No manual verification needed.
- **E-Ticket Generation:** Automatically generates a downloadable PDF E-Ticket with a unique **QR Code** upon successful payment.

### 🛡️ Security
- **IDOR Protection:** Strict authorization ensuring users can only download and view their own E-Tickets.
- **Webhook Security:** Configured CSRF exceptions for secure Midtrans server-to-server callbacks.
- **Overbooking Prevention:** Transaction-level locks and validation to prevent users and admins from exceeding ticket availability.

## 🚀 Tech Stack
- **Backend:** Laravel 11, PHP 8.2+
- **Admin Panel:** Filament v3
- **Frontend:** Tailwind CSS, Blade Templates
- **Payment Gateway:** Midtrans Snap API
- **PDF Generation:** Barryvdh DomPDF
- **Database:** MySQL / PostgreSQL

## 🛠️ Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/username/event-management-system.git
   cd event-management-system
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup:**
   Configure your database credentials in the `.env` file, then run:
   ```bash
   php artisan migrate --seed
   ```
   *(Note: The seeder will generate the default Admin account and Roles).*

5. **Midtrans Configuration:**
   Add your Midtrans API keys in the `.env` file:
   ```env
   MIDTRANS_SERVER_KEY=your-server-key-here
   MIDTRANS_CLIENT_KEY=your-client-key-here
   MIDTRANS_IS_PRODUCTION=false
   ```

6. **Serve the application:**
   ```bash
   php artisan serve
   ```

## 🔐 Default Admin Access
- **Email:** `admin@admin.com`
- **Password:** `password`
- **URL:** `http://localhost:8000/admin`

## 📄 License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
