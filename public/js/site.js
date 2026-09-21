document.addEventListener('DOMContentLoaded', () => {
  const menuBtn = document.getElementById('menuBtn');
  const nav = document.getElementById('mainNav');
  if (menuBtn && nav) {
    menuBtn.addEventListener('click', () => nav.classList.toggle('open'));
  }

  const filterToggle = document.querySelector('[data-filter-toggle]');
  const filters = document.getElementById('catalogFilters');
  if (filterToggle && filters) {
    filterToggle.addEventListener('click', () => {
      if (window.matchMedia('(max-width: 860px)').matches) filters.classList.toggle('open');
    });
  }

  document.querySelectorAll('[data-qty]').forEach(input => {
    const target = document.querySelector(input.dataset.totalTarget || '#orderTotal');
    const price = Number(input.dataset.price || 0);
    const unitFactor = Number(input.dataset.unitFactor || 1000);
    const update = () => {
      if (!target) return;
      const total = Number(input.value || 0) * price * unitFactor;
      target.textContent = new Intl.NumberFormat('fa-IR').format(total) + ' تومان';
    };
    input.addEventListener('input', update);
    update();
  });

  document.querySelectorAll('.radio-row input[type="radio"]').forEach(input => {
    input.addEventListener('change', () => {
      const name = input.name;
      if (!name) return;
      document.querySelectorAll('.radio-row input[name="' + name + '"]').forEach(item => {
        item.closest('.radio-row')?.classList.toggle('selected', item.checked);
      });
    });
  });

  setTimeout(() => document.querySelectorAll('.flash').forEach(f => {
    f.style.opacity = '0';
    setTimeout(() => f.remove(), 350);
  }), 4500);
});
