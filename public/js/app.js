document.addEventListener('DOMContentLoaded',()=>{
 const menu=document.getElementById('menuBtn'),nav=document.getElementById('mainNav'); if(menu&&nav)menu.addEventListener('click',()=>nav.classList.toggle('mobile-open'));
 const adminMenu=document.getElementById('adminMenu'),sidebar=document.querySelector('.admin-sidebar'); if(adminMenu&&sidebar)adminMenu.addEventListener('click',()=>sidebar.classList.toggle('open'));
 document.querySelectorAll('[data-tab]').forEach(btn=>btn.addEventListener('click',()=>{document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('active'));btn.classList.add('active');document.getElementById(btn.dataset.tab)?.classList.add('active')}));
 document.querySelectorAll('[data-modal]').forEach(btn=>btn.addEventListener('click',()=>document.getElementById(btn.dataset.modal)?.classList.add('open')));document.querySelectorAll('.modal-close').forEach(btn=>btn.addEventListener('click',()=>btn.closest('.modal')?.classList.remove('open')));document.querySelectorAll('.modal').forEach(m=>m.addEventListener('click',e=>{if(e.target===m)m.classList.remove('open')}));
 setTimeout(()=>document.querySelectorAll('.flash').forEach(f=>{f.style.opacity='0';setTimeout(()=>f.remove(),300)}),5000);
});
