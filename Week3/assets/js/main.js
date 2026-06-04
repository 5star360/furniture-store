/* ── Week 3: Category Filtering, Search & Animations ── */

document.addEventListener('DOMContentLoaded', () => {

  /* Product Catalog: Filter + Search */
  const searchInput  = document.getElementById('productSearch');
  const filterBtns   = document.querySelectorAll('.filter-btn');
  const productCards = document.querySelectorAll('.product-card');
  const noProducts   = document.getElementById('noProductsMsg');

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

  /* Animate cards on load */
  productCards.forEach((card, i) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    setTimeout(() => {
      card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, i * 60);
  });

});
