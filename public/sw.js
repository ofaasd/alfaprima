const CACHE_NAME = 'alfaprima-v1';
const STATIC_ASSETS = [
  '/',
  '/manifest.json',
  '/icons/icon-192.png',
  '/icons/icon-512.png',
  '/icons/icon-maskable-512.png',
  '/favicon.ico'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(STATIC_ASSETS);
    }).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys.map(key => {
          if (key !== CACHE_NAME) {
            return caches.delete(key);
          }
        })
      );
    }).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  const req = event.request;
  const url = new URL(req.url);

  // Jangan cache request non-GET atau request API / deploy
  if (req.method !== 'GET' || url.pathname.startsWith('/api/') || url.pathname.startsWith('/deploy')) {
    return;
  }

  // Network-First strategy untuk navigasi halaman & asset statis
  event.respondWith(
    fetch(req)
      .then(networkRes => {
        if (networkRes && networkRes.status === 200 && networkRes.type === 'basic') {
          const resClone = networkRes.clone();
          caches.open(CACHE_NAME).then(cache => {
            cache.put(req, resClone);
          });
        }
        return networkRes;
      })
      .catch(() => {
        // Jika offline, ambil dari cache
        return caches.match(req).then(cachedRes => {
          if (cachedRes) return cachedRes;
          // Fallback ke app shell untuk navigasi HTML jika offline
          if (req.mode === 'navigate') {
            return caches.match('/');
          }
        });
      })
  );
});
