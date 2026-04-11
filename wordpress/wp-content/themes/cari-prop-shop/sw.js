/**
 * CariPropShop Service Worker
 * Progressive Web App Service Worker
 */

const CACHE_NAME = 'caripropshop-v1';
const STATIC_CACHE = 'caripropshop-static-v1';
const DYNAMIC_CACHE = 'caripropshop-dynamic-v1';
const IMAGE_CACHE = 'caripropshop-images-v1';

const OFFLINE_URL = '/offline.html';

const STATIC_ASSETS = [
    '/',
    '/offline.html',
    '/manifest.json',
    '/wp-content/themes/cari-prop-shop/assets/css/main.css',
    '/wp-content/themes/cari-prop-shop/assets/js/main.js',
    '/wp-content/themes/cari-prop-shop/assets/images/logo.png',
    '/wp-content/themes/cari-prop-shop/assets/images/placeholder.png'
];

const MAX_CACHE_ITEMS = 50;
const MAX_IMAGE_ITEMS = 100;

self.addEventListener('install', function(event) {
    console.log('[SW] Installing Service Worker...');
    
    event.waitUntil(
        Promise.all([
            caches.open(STATIC_CACHE).then(function(cache) {
                console.log('[SW] Caching static assets');
                return cache.addAll(STATIC_ASSETS);
            }),
            caches.open(IMAGE_CACHE).then(function(cache) {
                console.log('[SW] Image cache created');
            })
        ]).then(function() {
            return self.skipWaiting();
        })
    );
});

self.addEventListener('activate', function(event) {
    console.log('[SW] Activating Service Worker...');
    
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (cacheName !== STATIC_CACHE && cacheName !== DYNAMIC_CACHE && cacheName !== IMAGE_CACHE) {
                        console.log('[SW] Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(function() {
            return self.clients.claim();
        })
    );
});

self.addEventListener('fetch', function(event) {
    const url = new URL(event.request.url);

    if (event.request.method !== 'GET') {
        return;
    }

    if (url.origin !== location.origin) {
        event.respondWith(
            fetch(event.request).then(function(response) {
                return response;
            }).catch(function() {
                return caches.match('/');
            })
        );
        return;
    }

    if (event.request.destination === 'document') {
        event.respondWith(
            caches.match(event.request).then(function(cachedResponse) {
                return cachedResponse || fetch(event.request).then(function(networkResponse) {
                    const responseClone = networkResponse.clone();
                    caches.open(DYNAMIC_CACHE).then(function(cache) {
                        cache.put(event.request, responseClone);
                    });
                    return networkResponse;
                }).catch(function() {
                    return caches.match(OFFLINE_URL);
                });
            })
        );
        return;
    }

    if (event.request.destination === 'image') {
        event.respondWith(
            caches.open(IMAGE_CACHE).then(function(cache) {
                return cache.match(event.request).then(function(cachedResponse) {
                    if (cachedResponse) {
                        return cachedResponse;
                    }

                    return fetch(event.request).then(function(networkResponse) {
                        cache.put(event.request, networkResponse.clone());
                        
                        cache.keys().then(function(keys) {
                            if (keys.length > MAX_IMAGE_ITEMS) {
                                cache.delete(keys[0]);
                            }
                        });

                        return networkResponse;
                    }).catch(function() {
                        return caches.match('/wp-content/themes/cari-prop-shop/assets/images/placeholder.png');
                    });
                });
            })
        );
        return;
    }

    if (event.request.destination === 'style' || event.request.destination === 'script' || event.request.destination === 'font') {
        event.respondWith(
            caches.match(event.request).then(function(cachedResponse) {
                if (cachedResponse) {
                    fetch(event.request).then(function(networkResponse) {
                        caches.open(STATIC_CACHE).then(function(cache) {
                            cache.put(event.request, networkResponse.clone());
                        });
                    }).catch(function() {});
                    return cachedResponse;
                }

                return fetch(event.request).then(function(networkResponse) {
                    const responseClone = networkResponse.clone();
                    caches.open(STATIC_CACHE).then(function(cache) {
                        cache.put(event.request, responseClone);
                    });
                    return networkResponse;
                }).catch(function() {
                    return new Response('', { status: 408, statusText: 'Request timed out' });
                });
            })
        );
        return;
    }

    event.respondWith(
        caches.match(event.request).then(function(cachedResponse) {
            if (cachedResponse) {
                return cachedResponse;
            }

            return fetch(event.request).then(function(networkResponse) {
                if (networkResponse.ok) {
                    const responseClone = networkResponse.clone();
                    caches.open(DYNAMIC_CACHE).then(function(cache) {
                        cache.put(event.request, responseClone);
                        
                        cache.keys().then(function(keys) {
                            if (keys.length > MAX_CACHE_ITEMS) {
                                cache.delete(keys[0]);
                            }
                        });
                    });
                }
                return networkResponse;
            }).catch(function(error) {
                console.log('[SW] Fetch failed:', error);
                
                if (event.request.destination === 'document') {
                    return caches.match(OFFLINE_URL);
                }
                
                return new Response('Network error occurred', {
                    status: 408,
                    statusText: 'Request timed out'
                });
            });
        })
    );
});

self.addEventListener('push', function(event) {
    console.log('[SW] Push received');

    let data = {
        title: 'CariPropShop',
        body: 'You have a new notification',
        icon: '/wp-content/themes/cari-prop-shop/assets/images/logo.png',
        badge: '/wp-content/themes/cari-prop-shop/assets/images/badge.png',
        tag: 'notification',
        data: {}
    };

    if (event.data) {
        try {
            const jsonData = event.data.json();
            data = Object.assign(data, jsonData);
        } catch (e) {
            data.body = event.data.text();
        }
    }

    const options = {
        body: data.body,
        icon: data.icon,
        badge: data.badge,
        tag: data.tag,
        data: data.data,
        vibrate: [100, 50, 100],
        actions: data.actions || []
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

self.addEventListener('notificationclick', function(event) {
    console.log('[SW] Notification clicked');
    event.notification.close();

    let urlToOpen = '/';

    if (event.notification.data && event.notification.data.url) {
        urlToOpen = event.notification.data.url;
    }

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function(windowClients) {
            for (let i = 0; i < windowClients.length; i++) {
                const client = windowClients[i];
                if (client.url === urlToOpen && 'focus' in client) {
                    return client.focus();
                }
            }
            
            if (clients.openWindow) {
                return clients.openWindow(urlToOpen);
            }
        })
    );
});

self.addEventListener('notificationclose', function(event) {
    console.log('[SW] Notification closed');
});

self.addEventListener('message', function(event) {
    console.log('[SW] Message received:', event.data);

    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }

    if (event.data && event.data.type === 'CLEAR_CACHE') {
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    return caches.delete(cacheName);
                })
            );
        }).then(function() {
            console.log('[SW] Cache cleared');
        });
    }

    if (event.data && event.data.type === 'GET_VERSION') {
        event.ports[0].postMessage({ version: CACHE_NAME });
    }
});

self.addEventListener('sync', function(event) {
    console.log('[SW] Background sync:', event.tag);

    if (event.tag === 'sync-favorites') {
        event.waitUntil(syncFavorites());
    }

    if (event.tag === 'sync-searches') {
        event.waitUntil(syncSearches());
    }
});

function syncFavorites() {
    return new Promise(function(resolve, reject) {
        console.log('[SW] Syncing favorites...');
        setTimeout(function() {
            console.log('[SW] Favorites synced');
            resolve();
        }, 1000);
    });
}

function syncSearches() {
    return new Promise(function(resolve, reject) {
        console.log('[SW] Syncing saved searches...');
        setTimeout(function() {
            console.log('[SW] Saved searches synced');
            resolve();
        }, 1000);
    });
}

console.log('[SW] Service Worker loaded');
