# 🛋️ Furnique – Week 1: Environment Setup & Project Structure

## Week 1 Focus
- XAMPP environment setup
- Project folder structure established
- Database connection file (`includes/db.php`)
- Authentication helpers (`includes/auth.php`)
- Basic HTML skeleton for index, login, register pages
- CSS design system loaded (`assets/css/style.css`)
- Database installer (`setup/install.php`)

## What's NOT included yet
- No product queries (Week 2+)
- No JavaScript filtering (Week 3+)
- No form validation logic (Week 4+)
- No admin panel / CRUD (Week 5+)
- Login/register forms are HTML-only (no PHP processing)

## Database
- Name: `Week1db` (rename to `week1db` in db.php)
- Run `setup/install.php` to create tables and seed data

## How to Run
1. Place `Week1/` folder in `htdocs/furniture-store/`
2. Start Apache + MySQL in XAMPP
3. Visit `http://localhost/furniture-store/setup/install.php`
4. Visit `http://localhost/furniture-store/index.php`
