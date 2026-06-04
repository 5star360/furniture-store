# 🛋️ Furnique – Week 4: Form Validation (JS + PHP)

## Week 4 Focus
- Builds on Week 3 (JS filtering, search, animations)
- Login page: PHP server-side validation + JavaScript client-side validation
- Register page: PHP validation (password strength, email uniqueness) + JS validation
- Session management integrated — catalog requires login
- Error messages displayed inline for better UX
- Password hashing with `password_hash()` on registration

## What's NOT included yet
- No admin panel / full CRUD (Week 5+)
- Product detail page (Week 5+)

## Database
- Name: `week4db`
- Import `week3db.sql` from Week 3, update `includes/db.php`

## Default Credentials (after running install.php)
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@furnitureshop.com | Admin@1234 |
| Customer | jane@example.com | Jane@1234 |

## How to Run
1. Place folder in `htdocs/furniture-store/`
2. Run `setup/install.php`
3. Visit `http://localhost/furniture-store/login.php`
