document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('quoteModal');
    const quickProduct = document.getElementById('quickProduct');
    const quickAmount = document.getElementById('quickAmount');
    const modalProduct = document.getElementById('modalProduct');
    const modalAmount = document.getElementById('modalAmount');

    const openQuote = () => {
        if (!modal) return;
        if (modalProduct) modalProduct.value = quickProduct?.value || '';
        if (modalAmount) modalAmount.value = quickAmount?.value || '';
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        setTimeout(() => modal.querySelector('input[name="name"]')?.focus(), 50);
    };

    const closeQuote = () => {
        if (!modal) return;
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    document.querySelectorAll('[data-open-quote]').forEach((button) => {
        button.addEventListener('click', openQuote);
    });
    document.querySelectorAll('[data-close-quote]').forEach((button) => {
        button.addEventListener('click', closeQuote);
    });
    modal?.addEventListener('click', (event) => {
        if (event.target === modal) closeQuote();
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal?.classList.contains('is-open')) closeQuote();
    });
});
