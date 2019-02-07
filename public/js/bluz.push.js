/**
 * Web Push
 *
 * @author   Anton Shevchuk
 * @created  07.11.2018 18:50
 */
/* global define,require,console */
define(['jquery', 'bluz', 'bluz.notify'], function ($, bluz, notify) {
  'use strict';

  let push = {};

  /**
   * Check browser compatibility
   * @return {boolean}
   */
  push.isAvailable = function() {
    if (!('serviceWorker' in navigator)) {
      console.warn('Service workers are not supported by this browser');
      return false;
    }

    if (!('PushManager' in window)) {
      console.warn('Push notifications are not supported by this browser');
      return false;
    }

    if (!('showNotification' in ServiceWorkerRegistration.prototype)) {
      console.warn('Notifications are not supported by this browser');
      return false;
    }

    return true;
  };

  /**
   * Try to register Service Worker
   * Please, keep worker inside root directory!
   */
  push.register = function() {
    // Try to register worker
    navigator.serviceWorker.register('serviceWorker.js')
      .then(() => {
        console.log('[PUSH] Service worker has been registered');
        // push.update();
      }, e => {
        console.error('[PUSH] Service worker registration failed', e);
      });
  };

  push.subscribe = function(serverKey) {
    console.log('[PUSH] Subscribe');
    navigator.serviceWorker.ready
      .then(serviceWorkerRegistration => serviceWorkerRegistration.pushManager.subscribe({
          userVisibleOnly: true,
          applicationServerKey: urlBase64ToUint8Array(serverKey),
        })
      )
      .then(subscription => {
        // Subscription was successful
        // create subscription on your server
        return sendSubscriptionToServer(subscription, 'POST');
      })
      .catch(e => {
        if (Notification.permission === 'denied') {
          // The user denied the notification permission which
          // means we failed to subscribe and the user will need
          // to manually change the notification permission to
          // subscribe to push messages
          console.warn('Notifications are denied by the user.');
        } else {
          // A problem occurred with the subscription; common reasons
          // include network errors or the user skipped the permission
          console.error('Impossible to subscribe to push notifications', e);
        }
      });
  };

  push.update = function() {
    console.log('[PUSH] Update subscription');
    navigator.serviceWorker.ready
      .then(serviceWorkerRegistration => serviceWorkerRegistration.pushManager.getSubscription())
      .then(subscription => {
        if (!subscription) {
          // We aren't subscribed to push, so set UI to allow the user to enable push
          return;
        }
        // Keep your server in sync with the latest endpoint
        return sendSubscriptionToServer(subscription, 'PUT');
      })
      .catch(e => {
        console.error('Error when updating the subscription', e);
      });
  };

  push.unsubscribe = function() {
    console.log('[PUSH] Unsubscribe');
    // To unsubscribe from push messaging, you need to get the subscription object
    navigator.serviceWorker.ready
      .then(serviceWorkerRegistration => serviceWorkerRegistration.pushManager.getSubscription())
      .then(subscription => {
        // Check that we have a subscription to unsubscribe
        if (!subscription) {
          // No subscription object, so set the state
          // to allow the user to subscribe to push
          return;
        }
        // We have a subscription, unsubscribe
        // Remove push subscription from server
        return sendSubscriptionToServer(subscription, 'DELETE');
      })
      .then(subscription => subscription.unsubscribe())
      .catch(e => {
        // We failed to unsubscribe, this can lead to
        // an unusual state, so  it may be best to remove
        // the users data from your data store and
        // inform the user that you have done so
        console.error('Error when unsubscribing the user', e);
      });
  };

  function sendSubscriptionToServer(subscription, method) {
    const key = subscription.getKey('p256dh');
    const token = subscription.getKey('auth');
    const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0];

    return $.ajax({
      url: '/push/subscription',
      method: method,
      dataType: 'json',
      data: {
        endpoint: subscription.endpoint,
        publicKey: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
        authToken: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null,
        contentEncoding
      }
    }).then(() => subscription);
  }

  function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
      .replace(/\-/g, '+')
      .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
      outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
  }

  return push;
});
