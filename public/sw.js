// Minimal service worker for PWA installation
// This allows the app to be installable
// We'll add offline functionality later

const CACHE_NAME = 'wheremoneygoes-v1';

self.addEventListener('install', (event) => {
  console.log('Service Worker: Installed');
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  console.log('Service Worker: Activated');
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) {
            console.log('Service Worker: Clearing old cache');
            return caches.delete(cache);
          }
        })
      );
    })
  );
});

// For now, just pass through all requests to the network
// We'll add offline caching later
self.addEventListener('fetch', (event) => {
  event.respondWith(fetch(event.request));
});
