const CACHE_VERSION = 'myagri-pwa-v2026-06-01';
const STATIC_CACHE = `${CACHE_VERSION}-static`;
const RUNTIME_CACHE = `${CACHE_VERSION}-runtime`;

const PRECACHE_URLS = [
    '/',
    '/?page=accueil',
    '/?page=filieres',
    '/?page=ressources',
    '/?page=faq',
    '/?page=glossaire',
    '/offline.html',
    '/manifest.json',
    '/assets/css/style.css',
    '/assets/js/main.js',
    '/assets/img/hero.png',
    '/assets/img/favicon-32.png',
    '/assets/img/apple-touch-icon.png',
    '/assets/img/pwa-icon-192.png',
    '/assets/img/pwa-icon-512.png',
    '/assets/img/pwa-maskable-512.png'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then((cache) => cache.addAll(PRECACHE_URLS))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    const expectedCaches = [STATIC_CACHE, RUNTIME_CACHE];

    event.waitUntil(
        caches.keys()
            .then((cacheNames) => Promise.all(
                cacheNames
                    .filter((cacheName) => !expectedCaches.includes(cacheName))
                    .map((cacheName) => caches.delete(cacheName))
            ))
            .then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    const { request } = event;

    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);
    if (url.origin !== self.location.origin) {
        return;
    }

    if (isNavigationRequest(request)) {
        event.respondWith(networkFirst(request, true));
        return;
    }

    if (url.pathname === '/api.php') {
        event.respondWith(networkFirst(request, false));
        return;
    }

    if (isStaticAsset(request, url)) {
        event.respondWith(staleWhileRevalidate(request));
    }
});

function isNavigationRequest(request) {
    return request.mode === 'navigate'
        || (request.destination === 'document' && request.headers.get('accept')?.includes('text/html'));
}

function isStaticAsset(request, url) {
    return ['style', 'script', 'image', 'font', 'manifest'].includes(request.destination)
        || url.pathname.startsWith('/assets/')
        || url.pathname === '/manifest.json'
        || url.pathname === '/offline.html';
}

async function networkFirst(request, useOfflineFallback) {
    try {
        const response = await fetch(request);
        if (response && response.ok) {
            const cache = await caches.open(RUNTIME_CACHE);
            cache.put(request, response.clone());
        }
        return response;
    } catch (error) {
        const cached = await caches.match(request);
        if (cached) {
            return cached;
        }

        if (useOfflineFallback) {
            return (await caches.match('/offline.html')) || Response.error();
        }

        return Response.error();
    }
}

async function staleWhileRevalidate(request) {
    const cache = await caches.open(STATIC_CACHE);
    const cached = await cache.match(request);

    const fetchPromise = fetch(request)
        .then((response) => {
            if (response && response.ok) {
                cache.put(request, response.clone());
            }
            return response;
        })
        .catch(() => cached);

    return cached || fetchPromise;
}
