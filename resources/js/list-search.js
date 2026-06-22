document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-list-search]').forEach((input) => {
        const listId = input.dataset.listSearch;
        const list = document.getElementById(listId);

        if (!list) {
            return;
        }

        const items = Array.from(list.querySelectorAll('[data-search-item]'));

        input.addEventListener('input', () => {
            const search = input.value.trim().toLowerCase();

            items.forEach((item) => {
                const text = item.dataset.searchText || '';
                item.classList.toggle('hidden', !text.includes(search));
            });
        });
    });
});