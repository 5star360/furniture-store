# 🛋️ Furnique – Week 5: Full MySQL CRUD & Admin Panel

## Week 5 Focus (COMPLETE PROJECT)
- Builds on all previous weeks
- Full admin panel with CRUD operations:
  - **Create**: Add new products (with image URL)
  - **Read**: View all products, users, dashboard stats
  - **Update**: Edit existing products
  - **Delete**: Remove products
- Role-based access control (admin vs customer)
- Admin dashboard with stats (total products, users, categories)
- Users management page for admins
- Product detail page (`product.php`)
- Session-based authentication fully integrated
- Password hashing with `password_hash()` / `password_verify()`

## Database
- Name: `week5db`
- Import `week4db.sql` from Week 4, update `includes/db.php`
- Or run `setup/install.php` fresh

## Default Credentials
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@furnitureshop.com | Admin@1234 |
| Customer | jane@example.com | Jane@1234 |

## How to Run
1. Place folder in `htdocs/furniture-store/`
2. Run `setup/install.php` to create `week5db` and seed data
3. Visit `http://localhost/furniture-store/login.php`
4. Admin: goes to `admin/dashboard.php`, Customer: goes to `index.php`

## Admin Panel Pages
- `/admin/dashboard.php` — Stats overview
- `/admin/products.php` — List all products
- `/admin/add_product.php` — Add new product
- `/admin/edit_product.php?id=X` — Edit product
- `/admin/delete_product.php?id=X` — Delete product
- `/admin/users.php` — View all registered users
