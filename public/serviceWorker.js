/**
 * Service Worker
 *
 * Please keep it inside root directory!
 *
 * @link https://github.com/web-push-libs/web-push-php
 */
self.addEventListener('push', function (event) {
  if (!(self.Notification && self.Notification.permission === 'granted')) {
    return;
  }

  const sendNotification = body => {
    // you could refresh a notification badge here with postMessage API
    const title = 'Bluz notification';

    return self.registration.showNotification(title, JSON.parse(body));
  };

  if (event.data) {
    const message = event.data.text();
    event.waitUntil(sendNotification(message));
  }
});
