const input = document.querySelector('#search');
const results = document.querySelector('#search-results');
const statusEl = document.querySelector('#search-status');

if (input && results && statusEl) {
    let timer;
    let controller;

    input.addEventListener('input', () => {
        clearTimeout(timer);
        controller?.abort();
        results.replaceChildren();

        const term = input.value.trim();
        if (term.length < 2) {
            statusEl.textContent = '';
            return;
        }

        statusEl.textContent = input.dataset.searching;
        timer = setTimeout(async () => {
            controller = new AbortController();

            try {
                const url = new URL(input.dataset.searchUrl, window.location.origin);
                url.searchParams.set('q', term);

                const response = await fetch(url, {
                    headers: { Accept: 'application/json' },
                    signal: controller.signal,
                });
                if (!response.ok) throw new Error('Recherche indisponible');

                const payload = await response.json();
                const items = Array.isArray(payload.data) ? payload.data : [];

                statusEl.textContent = items.length
                    ? input.dataset.count.replace(':count', items.length)
                    : input.dataset.empty;

                for (const item of items) {
                    const link = document.createElement('a');
                    link.href = item.url;
                    link.textContent = item.label;
                    link.className = 'block py-2 text-sm text-slate-800 hover:text-slate-900 hover:underline';

                    const row = document.createElement('li');
                    row.append(link);
                    results.append(row);
                }
            } catch (error) {
                if (error.name !== 'AbortError') {
                    statusEl.textContent = input.dataset.error;
                }
            }
        }, 250);
    });
}
