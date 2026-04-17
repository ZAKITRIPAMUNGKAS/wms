const CACHE_NAME = 'wms-cache-v1';
const ASSETS_TO_CACHE = [
    '/',
    '/offline',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
});

self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Stale-while-revalidate for assets and Inertia requests
    if (request.method === 'GET' && 
        (url.origin === self.location.origin || url.pathname.includes('/api/'))) {
        
        event.respondWith(
            caches.open(CACHE_NAME).then((cache) => {
                return cache.match(request).then((cachedResponse) => {
                    const fetchedResponse = fetch(request).then((networkResponse) => {
                        cache.put(request, networkResponse.clone());
                        return networkResponse;
                    }).catch(() => cachedResponse);

                    return cachedResponse || fetchedResponse;
                });
            })
        );
    }
});
