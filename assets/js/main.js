const filterInput = document.querySelector('[data-sector-filter]');
const sectorCards = Array.from(document.querySelectorAll('[data-sector-card]'));

if (filterInput && sectorCards.length) {
    filterInput.addEventListener('input', (event) => {
        const value = event.target.value.toLowerCase().trim();
        sectorCards.forEach((card) => {
            const text = card.dataset.searchText || '';
            card.hidden = !text.includes(value);
        });
    });
}

const faqButtons = Array.from(document.querySelectorAll('[data-faq-button]'));
faqButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const target = document.getElementById(button.getAttribute('aria-controls'));
        if (!target) return;
        const expanded = button.getAttribute('aria-expanded') === 'true';
        button.setAttribute('aria-expanded', String(!expanded));
        target.hidden = expanded;
    });
});
