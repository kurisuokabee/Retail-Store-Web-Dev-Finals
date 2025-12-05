# Online Retail Store Management System for Web Dev Final Project

## Description
A web-based retail store application built with **Laravel**, **Composer**, and **NPM**. This project allows users to browse products, manage a cart, place orders, and view order history.


---

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Database Setup](#database-setup)
- [Team Members](#team-members)
- [License](#license)

---

## Features
- Browse products 
- Add products to cart
- Checkout with delivery and payment options
- View order history and details
- User authentication (login/register)
- Admin store management
- Store Analytics

---

## Installation / Setup


1. Clone the repository
```bash
git clone https://github.com/kurisuokabee/Retail-Store-Web-Dev-Finals
cd retailstore
```

2. Install Composer dependencies
```bash
composer install
```

3. Install NPM dependencies
```bash
npm install
npm run dev
```

4. Copy the .env.example to .env
```bash
cp .env.example .env
```

5. Generate the application key
```bash
php artisan key:generate
```
## Usage

```bash

#1. Start the local development server
php artisan serve

```

## Database Setup

1. Create a MySQL database for the project.
2. Update the .env file with your database credentials.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

```bash
#3. Run migrations and seed the database:
php artisan migrate --seed
```

# Team Members

Team Members

1. Cian Stephen Lee – Frontend Developer
2. Angelo Tactay – Backend Developer
3. Rico Nathaniel Tan – Frontend Developer
4. Sev Jand Daniel Torreon – Backend Developer
5. Tyler John Uri – Frontend Developer

# License
This project is open-source and available under the MIT License.