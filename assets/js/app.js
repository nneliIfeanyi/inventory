if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('sw.js')
      .then((registration) => {
        console.log('Service worker registered with scope:', registration.scope);
      })
      .catch((error) => {
        console.warn('Service worker registration failed:', error);
      });
  });
}

window.addEventListener('beforeinstallprompt', (event) => {
  event.preventDefault();
  window.deferredPWAInstallPrompt = event;
  console.log('PWA install prompt saved.');
});

function promptPWAInstall() {
  const promptEvent = window.deferredPWAInstallPrompt;
  if (!promptEvent) {
    return Promise.reject(new Error('Install prompt not available'));
  }

  promptEvent.prompt();
  return promptEvent.userChoice.then((choiceResult) => {
    window.deferredPWAInstallPrompt = null;
    return choiceResult;
  });
}
