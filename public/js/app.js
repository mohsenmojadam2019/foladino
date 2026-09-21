document.addEventListener('DOMContentLoaded', () => {
  const adminMenu = document.getElementById('adminMenu');
  const sidebar = document.getElementById('adminSidebar') || document.querySelector('.admin-sidebar');
  if (adminMenu && sidebar) adminMenu.addEventListener('click', () => sidebar.classList.toggle('open'));

  document.querySelectorAll('[data-tab]').forEach(btn => btn.addEventListener('click', () => {
    const root = btn.closest('.admin-content') || document;
    root.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    root.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(btn.dataset.tab)?.classList.add('active');
  }));

  document.querySelectorAll('[data-modal]').forEach(btn => {
    btn.addEventListener('click', () => document.getElementById(btn.dataset.modal)?.classList.add('open'));
  });

  document.querySelectorAll('.modal-close').forEach(btn => {
    btn.addEventListener('click', () => btn.closest('.modal')?.classList.remove('open'));
  });

  document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', e => { if (e.target === modal) modal.classList.remove('open'); });
  });

  document.querySelectorAll('.admin-edit-product').forEach(btn => {
    btn.addEventListener('click', () => {
      const form = document.getElementById('editProductForm');
      if (!form) return;
      form.action = '/admin/products/' + btn.dataset.id;
      const set = (id, value) => { const el = document.getElementById(id); if (el) el.value = value ?? ''; };
      set('edit_name', btn.dataset.name);
      set('edit_category', btn.dataset.category);
      set('edit_factory', btn.dataset.factory);
      set('edit_size', btn.dataset.size);
      set('edit_standard', btn.dataset.standard);
      set('edit_price', btn.dataset.price);
      set('edit_change', btn.dataset.change);
      set('edit_stock', btn.dataset.stock);
      const featured = document.getElementById('edit_featured');
      const active = document.getElementById('edit_active');
      if (featured) featured.checked = btn.dataset.featured === '1';
      if (active) active.checked = btn.dataset.active === '1';
    });
  });

  document.querySelectorAll('[data-admin-table-search]').forEach(input => {
    const table = document.querySelector(input.dataset.adminTableSearch);
    if (!table) return;
    input.addEventListener('input', () => {
      const q = input.value.trim().toLocaleLowerCase('fa');
      table.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = !q || row.innerText.toLocaleLowerCase('fa').includes(q) ? '' : 'none';
      });
    });
  });

  document.querySelectorAll('[data-admin-status-filter]').forEach(select => {
    const table = document.querySelector(select.dataset.adminStatusFilter);
    if (!table) return;
    select.addEventListener('change', () => {
      const value = select.value;
      table.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = !value || row.dataset.status === value ? '' : 'none';
      });
    });
  });

  const crmSearch = document.querySelector('[data-crm-search]');
  if (crmSearch) {
    crmSearch.addEventListener('input', () => {
      const q = crmSearch.value.trim().toLocaleLowerCase('fa');
      document.querySelectorAll('.crm-card').forEach(card => {
        const text = (card.dataset.crmText || card.innerText).toLocaleLowerCase('fa');
        card.style.display = !q || text.includes(q) ? '' : 'none';
      });
    });
  }

  const contentSearch = document.querySelector('[data-content-search]');
  if (contentSearch) {
    contentSearch.addEventListener('input', () => {
      const q = contentSearch.value.trim().toLocaleLowerCase('fa');
      document.querySelectorAll('[data-content-text]').forEach(card => {
        card.style.display = !q || card.dataset.contentText.toLocaleLowerCase('fa').includes(q) ? '' : 'none';
      });
    });
  }

  setTimeout(() => document.querySelectorAll('.flash').forEach(f => {
    f.style.opacity = '0';
    f.style.transition = '.3s';
    setTimeout(() => f.remove(), 300);
  }), 4500);
});