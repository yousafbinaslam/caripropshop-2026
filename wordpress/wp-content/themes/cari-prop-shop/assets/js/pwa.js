/**
 * CariPropShop PWA Setup
 * Progressive Web App functionality
 */

(function($) {
    'use strict';

    const CPS_PWA = {
        isStandalone: false,
        deferredPrompt: null,

        init: function() {
            this.checkStandalone();
            this.registerServiceWorker();
            this.setupInstallPrompt();
            this.setupOfflineSupport();
            this.setupPushNotifications();
        },

        checkStandalone: function() {
            this.isStandalone = window.matchMedia('(display-mode: standalone)').matches || 
                                window.navigator.standalone === true;
        },

        registerServiceWorker: function() {
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js')
                        .then(function(registration) {
                            console.log('ServiceWorker registration successful:', registration.scope);
                        })
                        .catch(function(err) {
                            console.log('ServiceWorker registration failed:', err);
                        });
                });
            }
        },

        setupInstallPrompt: function() {
            window.addEventListener('beforeinstallprompt', function(e) {
                e.preventDefault();
                CPS_PWA.deferredPrompt = e;
                CPS_PWA.showInstallBanner();
            });

            window.addEventListener('appinstalled', function() {
                CPS_PWA.hideInstallBanner();
                CPS_PWA.deferredPrompt = null;
                CPS_PWA.showInstallSuccess();
            });
        },

        showInstallBanner: function() {
            if ($('#pwa-install-banner').length === 0) {
                const banner = `
                    <div id="pwa-install-banner" class="pwa-banner">
                        <div class="pwa-banner-content">
                            <div class="pwa-banner-icon">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                    <rect width="48" height="48" rx="12" fill="#3498db"/>
                                    <path d="M24 10L14 18V30L24 38L34 30V18L24 10Z" stroke="white" stroke-width="2" fill="none"/>
                                    <circle cx="24" cy="24" r="6" fill="white"/>
                                </svg>
                            </div>
                            <div class="pwa-banner-text">
                                <h4>Install CariPropShop App</h4>
                                <p>Add to your home screen for a better experience</p>
                            </div>
                            <div class="pwa-banner-actions">
                                <button id="pwa-install-btn" class="btn btn-primary">Install</button>
                                <button id="pwa-dismiss-btn" class="btn btn-text">Not Now</button>
                            </div>
                        </div>
                    </div>
                `;
                $('body').append(banner);

                $('#pwa-install-btn').on('click', this.installApp.bind(this));
                $('#pwa-dismiss-btn').on('click', this.dismissBanner.bind(this));
            }
        },

        hideInstallBanner: function() {
            $('#pwa-install-banner').fadeOut(function() {
                $(this).remove();
            });
        },

        dismissBanner: function() {
            this.hideInstallBanner();
            localStorage.setItem('pwaBannerDismissed', 'true');
            localStorage.setItem('pwaBannerDismissedTime', Date.now());
        },

        installApp: function() {
            if (this.deferredPrompt) {
                this.deferredPrompt.prompt();
                this.deferredPrompt.userChoice.then(function(choiceResult) {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the A2HS prompt');
                    }
                    CPS_PWA.deferredPrompt = null;
                    CPS_PWA.hideInstallBanner();
                });
            }
        },

        showInstallSuccess: function() {
            const toast = `
                <div class="pwa-toast success">
                    <i class="fas fa-check-circle"></i>
                    <span>App installed successfully!</span>
                </div>
            `;
            $('body').append(toast);
            setTimeout(function() {
                $('.pwa-toast').fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        },

        setupOfflineSupport: function() {
            window.addEventListener('offline', this.showOfflineMessage.bind(this));
            window.addEventListener('online', this.hideOfflineMessage.bind(this));

            if (!navigator.onLine) {
                this.showOfflineMessage();
            }
        },

        showOfflineMessage: function() {
            if ($('#pwa-offline-banner').length === 0) {
                const banner = `
                    <div id="pwa-offline-banner" class="pwa-banner offline">
                        <div class="pwa-banner-content">
                            <i class="fas fa-wifi-slash"></i>
                            <span>You're offline. Some features may be unavailable.</span>
                            <button onclick="CPS_PWA.hideOfflineMessage()" class="btn btn-sm">OK</button>
                        </div>
                    </div>
                `;
                $('body').append(banner);
            }
        },

        hideOfflineMessage: function() {
            $('#pwa-offline-banner').fadeOut(function() {
                $(this).remove();
            });
        },

        setupPushNotifications: function() {
            if ('Notification' in window && Notification.permission === 'default') {
                this.showNotificationPrompt();
            }
        },

        showNotificationPrompt: function() {
            if (localStorage.getItem('notificationPromptDismissed')) {
                return;
            }

            const prompt = `
                <div id="pwa-notification-prompt" class="pwa-banner notification">
                    <div class="pwa-banner-content">
                        <div class="pwa-banner-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="pwa-banner-text">
                            <h4>Enable Notifications</h4>
                            <p>Get notified about new properties and price changes</p>
                        </div>
                        <div class="pwa-banner-actions">
                            <button id="pwa-enable-notifications" class="btn btn-primary">Enable</button>
                            <button id="pwa-dismiss-notifications" class="btn btn-text">Later</button>
                        </div>
                    </div>
                </div>
            `;
            $('body').append(prompt);

            $('#pwa-enable-notifications').on('click', this.enableNotifications.bind(this));
            $('#pwa-dismiss-notifications').on('click', this.dismissNotificationPrompt.bind(this));
        },

        enableNotifications: function() {
            Notification.requestPermission(function(permission) {
                if (permission === 'granted') {
                    CPS_PWA.subscribeToPush();
                    CPS_PWA.showNotificationSuccess();
                }
                CPS_PWA.hideNotificationPrompt();
            });
        },

        dismissNotificationPrompt: function() {
            localStorage.setItem('notificationPromptDismissed', 'true');
            this.hideNotificationPrompt();
        },

        hideNotificationPrompt: function() {
            $('#pwa-notification-prompt').fadeOut(function() {
                $(this).remove();
            });
        },

        showNotificationSuccess: function() {
            const toast = `
                <div class="pwa-toast success">
                    <i class="fas fa-check-circle"></i>
                    <span>Notifications enabled!</span>
                </div>
            `;
            $('body').append(toast);
            setTimeout(function() {
                $('.pwa-toast').fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        },

        subscribeToPush: function() {
            if ('serviceWorker' in navigator && 'PushManager' in window) {
                navigator.serviceWorker.ready.then(function(registration) {
                    const vapidPublicKey = 'BCkGsYSQRKQALghFPxYxQRxQxUqVxJjw26lZ8x2c1G6B5zK5R2x5R2x5R2x5R2x5R2x5R2x5R2x5R2x5Q=';
                    const convertedVapidKey = this.urlBase64ToUint8Array(vapidPublicKey);

                    registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: convertedVapidKey
                    }).then(function(subscription) {
                        CPS_PWA.savePushSubscription(subscription);
                    });
                }.bind(this));
            }
        },

        savePushSubscription: function(subscription) {
            const key = subscription.getKey('p256dh');
            const token = subscription.getKey('auth');
            const endpoint = subscription.endpoint;

            const data = {
                endpoint: endpoint,
                key: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : '',
                token: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : ''
            };

            $.ajax({
                url: cpsData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cps_save_push_subscription',
                    nonce: cpsData.nonce,
                    subscription: JSON.stringify(data)
                }
            });
        },

        urlBase64ToUint8Array: function(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);
            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        },

        shareProperty: function(propertyId, propertyTitle, propertyUrl) {
            if (navigator.share) {
                navigator.share({
                    title: propertyTitle,
                    text: 'Check out this property: ' + propertyTitle,
                    url: propertyUrl
                }).catch(function(error) {
                    console.log('Error sharing:', error);
                });
            } else {
                this.copyToClipboard(propertyUrl);
            }
        },

        copyToClipboard: function(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            
            const toast = `
                <div class="pwa-toast">
                    <i class="fas fa-check"></i>
                    <span>Link copied to clipboard!</span>
                </div>
            `;
            $('body').append(toast);
            setTimeout(function() {
                $('.pwa-toast').fadeOut(function() {
                    $(this).remove();
                });
            }, 2000);
        }
    };

    $(document).ready(function() {
        CPS_PWA.init();
    });

    window.CPS_PWA = CPS_PWA;

})(jQuery);
