(function () {
  var root = document.documentElement;
  var previousHeight = 0;
  var ticking = false;

  function viewportSize() {
    var vv = window.visualViewport;

    return {
      width: vv ? vv.width : window.innerWidth,
      height: vv ? vv.height : window.innerHeight,
      top: vv ? vv.offsetTop : 0
    };
  }

  function applyViewportVars() {
    ticking = false;

    var size = viewportSize();
    var height = Math.max(320, Math.round(size.height));
    var width = Math.max(320, Math.round(size.width));
    var keyboardOpen = window.innerHeight - height > 140;

    root.style.setProperty('--app-height', height + 'px');
    root.style.setProperty('--app-width', width + 'px');
    root.style.setProperty('--visual-viewport-top', Math.round(size.top) + 'px');
    root.classList.toggle('keyboard-open', keyboardOpen);

    previousHeight = height;
  }

  function scheduleViewportUpdate() {
    if (ticking) {
      return;
    }

    ticking = true;
    window.requestAnimationFrame(applyViewportVars);
  }

  applyViewportVars();

  window.addEventListener('resize', scheduleViewportUpdate, { passive: true });
  window.addEventListener('orientationchange', function () {
    setTimeout(scheduleViewportUpdate, 80);
    setTimeout(scheduleViewportUpdate, 280);
  }, { passive: true });
  window.addEventListener('pageshow', scheduleViewportUpdate, { passive: true });

  if (window.visualViewport) {
    window.visualViewport.addEventListener('resize', scheduleViewportUpdate, { passive: true });
    window.visualViewport.addEventListener('scroll', scheduleViewportUpdate, { passive: true });
  }

  if ('ResizeObserver' in window) {
    new ResizeObserver(function () {
      var currentHeight = viewportSize().height;

      if (Math.abs(currentHeight - previousHeight) > 2) {
        scheduleViewportUpdate();
      }
    }).observe(document.documentElement);
  }
})();
