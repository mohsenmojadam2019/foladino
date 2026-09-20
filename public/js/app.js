document.addEventListener('DOMContentLoaded', () => {
  const menu = document.getElementById('menuBtn');
  const nav = document.getElementById('mainNav');
  if (menu && nav) menu.addEventListener('click', () => nav.classList.toggle('mobile-open'));

  const adminMenu = document.getElementById('adminMenu');
  const sidebar = document.querySelector('.admin-sidebar');
  if (adminMenu && sidebar) adminMenu.addEventListener('click', () => sidebar.classList.toggle('open'));

  document.querySelectorAll('[data-tab]').forEach(btn => btn.addEventListener('click', () => {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(btn.dataset.tab)?.classList.add('active');
  }));

  document.querySelectorAll('[data-modal]').forEach(btn =>
    btn.addEventListener('click', () => document.getElementById(btn.dataset.modal)?.classList.add('open'))
  );
  document.querySelectorAll('.modal-close').forEach(btn =>
    btn.addEventListener('click', () => btn.closest('.modal')?.classList.remove('open'))
  );
  document.querySelectorAll('.modal').forEach(m =>
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); })
  );

  const search = document.getElementById('globalSearch');
  if (search) {
    const rows = [...document.querySelectorAll('.prices-panel tbody tr')];
    const cards = [...document.querySelectorAll('.category-card')];
    const run = () => {
      const q = search.value.trim().toLocaleLowerCase('fa');
      rows.forEach(row => row.style.display = !q || row.innerText.toLocaleLowerCase('fa').includes(q) ? '' : 'none');
      cards.forEach(card => card.style.opacity = !q || card.innerText.toLocaleLowerCase('fa').includes(q) ? '1' : '.28');
    };
    search.addEventListener('input', run);
    search.addEventListener('keydown', e => {
      if (e.key === 'Enter') {
        e.preventDefault();
        run();
        document.getElementById('prices')?.scrollIntoView({behavior:'smooth'});
      }
    });
  }

  setTimeout(() => document.querySelectorAll('.flash').forEach(f => {
    f.style.opacity = '0';
    setTimeout(() => f.remove(), 300);
  }), 5000);
});
