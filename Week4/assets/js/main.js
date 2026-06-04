/* ────────────────────────────────────────────────
   Furniture Store – main.js
   ──────────────────────────────────────────────── */

document.addEventListener('DOMContentLoaded', () => {

  /* ── Product Catalog: Filter + Search ─────────── */
  const searchInput   = document.getElementById('productSearch');
  const filterBtns    = document.querySelectorAll('.filter-btn');
  const productCards  = document.querySelectorAll('.product-card');
  const noProducts    = document.getElementById('noProductsMsg');

  let activeCategory = 'all';

  function filterProducts() {
    const q = searchInput ? searchInput.value.trim().toLowerCase() : '';
    let visible = 0;
    productCards.forEach(card => {
      const name     = (card.dataset.name     || '').toLowerCase();
      const category = (card.dataset.category || '').toLowerCase();
      const desc     = (card.dataset.desc     || '').toLowerCase();
      const matchQ   = !q || name.includes(q) || desc.includes(q);
      const matchCat = activeCategory === 'all' || category === activeCategory;
      if (matchQ && matchCat) {
        card.style.display = '';
        card.style.animation = 'fadeIn .3s ease';
        visible++;
      } else {
        card.style.display = 'none';
      }
    });
    if (noProducts) noProducts.style.display = visible === 0 ? '' : 'none';
  }

  if (searchInput) {
    searchInput.addEventListener('input', filterProducts);
  }

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeCategory = btn.dataset.category;
      filterProducts();
    });
  });

  /* ── Form Validation ───────────────────────────── */

  // Generic validator
  function showError(input, msg) {
    input.classList.add('error');
    let err = input.parentElement.querySelector('.field-error');
    if (!err) {
      err = document.createElement('span');
      err.className = 'field-error';
      input.parentElement.appendChild(err);
    }
    err.textContent = msg;
  }

  function clearError(input) {
    input.classList.remove('error');
    const err = input.parentElement.querySelector('.field-error');
    if (err) err.textContent = '';
  }

  function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function validatePhone(phone) {
    return /^[\d\s+\-()]{7,15}$/.test(phone);
  }

  // Live clear-error on input
  document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('input', () => clearError(input));
  });

  /* ── Registration Form ─────────────────────────── */
  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', function (e) {
      let valid = true;

      const name  = this.querySelector('[name="name"]');
      const email = this.querySelector('[name="email"]');
      const phone = this.querySelector('[name="phone"]');
      const pass  = this.querySelector('[name="password"]');
      const conf  = this.querySelector('[name="confirm_password"]');

      if (!name.value.trim() || name.value.trim().length < 2) {
        showError(name, 'Full name must be at least 2 characters.'); valid = false;
      }
      if (!validateEmail(email.value)) {
        showError(email, 'Please enter a valid email address.'); valid = false;
      }
      if (phone && !validatePhone(phone.value)) {
        showError(phone, 'Enter a valid phone number (7–15 digits).'); valid = false;
      }
      if (!pass.value || pass.value.length < 8) {
        showError(pass, 'Password must be at least 8 characters.'); valid = false;
      } else if (!/[A-Z]/.test(pass.value)) {
        showError(pass, 'Password must contain at least one uppercase letter.'); valid = false;
      } else if (!/[0-9]/.test(pass.value)) {
        showError(pass, 'Password must contain at least one number.'); valid = false;
      }
      if (conf && pass.value !== conf.value) {
        showError(conf, 'Passwords do not match.'); valid = false;
      }

      if (!valid) e.preventDefault();
    });

    // Password strength meter
    const passInput = registerForm.querySelector('[name="password"]');
    const strengthBar = document.getElementById('strengthBar');
    if (passInput && strengthBar) {
      passInput.addEventListener('input', () => {
        const v = passInput.value;
        let score = 0;
        if (v.length >= 8) score++;
        if (/[A-Z]/.test(v)) score++;
        if (/[0-9]/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;
        const colors = ['#e74c3c','#e67e22','#f1c40f','#27ae60'];
        strengthBar.style.width  = (score * 25) + '%';
        strengthBar.style.background = colors[score - 1] || '#ddd';
      });
    }
  }

  /* ── Login Form ────────────────────────────────── */
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      let valid = true;
      const email = this.querySelector('[name="email"]');
      const pass  = this.querySelector('[name="password"]');
      if (!validateEmail(email.value)) {
        showError(email, 'Please enter a valid email address.'); valid = false;
      }
      if (!pass.value.trim()) {
        showError(pass, 'Password is required.'); valid = false;
      }
      if (!valid) e.preventDefault();
    });
  }

  /* ── Admin Product Form ────────────────────────── */
  const productForm = document.getElementById('productForm');
  if (productForm) {
    productForm.addEventListener('submit', function (e) {
      let valid = true;
      const nm   = this.querySelector('[name="name"]');
      const pr   = this.querySelector('[name="price"]');
      const cat  = this.querySelector('[name="category"]');
      const desc = this.querySelector('[name="description"]');

      if (!nm.value.trim() || nm.value.trim().length < 3) {
        showError(nm, 'Product name must be at least 3 characters.'); valid = false;
      }
      if (!pr.value || isNaN(pr.value) || parseFloat(pr.value) <= 0) {
        showError(pr, 'Enter a valid positive price.'); valid = false;
      }
      if (!cat.value) {
        showError(cat, 'Please select a category.'); valid = false;
      }
      if (!desc.value.trim() || desc.value.trim().length < 10) {
        showError(desc, 'Description must be at least 10 characters.'); valid = false;
      }
      if (!valid) e.preventDefault();
    });
  }

  /* ── Delete Confirmation ───────────────────────── */
  document.querySelectorAll('.confirm-delete').forEach(btn => {
    btn.addEventListener('click', function (e) {
      if (!confirm('Are you sure you want to delete this item? This cannot be undone.')) {
        e.preventDefault();
      }
    });
  });

  /* ── Auto-dismiss alerts ───────────────────────── */
  document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
      alert.style.transition = 'opacity .5s';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 500);
    }, 4000);
  });

  /* ── Fade-in animation ─────────────────────────── */
  const style = document.createElement('style');
  style.textContent = '@keyframes fadeIn{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}';
  document.head.appendChild(style);

  // Staggered product card entrance
  productCards.forEach((card, i) => {
    card.style.opacity = '0';
    card.style.animationDelay = `${i * 60}ms`;
    card.style.animation = `fadeIn .4s ease ${i * 60}ms forwards`;
  });

});
