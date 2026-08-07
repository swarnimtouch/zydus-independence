document.addEventListener('DOMContentLoaded', function () {
  var image = document.querySelector('.atorva-bg-image');

  if (!image) {
    return;
  }

  function markLoaded() {
    document.body.classList.add('atorva-image-ready');
  }

  if (image.complete) {
    markLoaded();
  } else {
    image.addEventListener('load', markLoaded, { once: true });
  }

  if (window.matchMedia('(max-width: 767px)').matches) {
    window.scrollTo(0, 0);
  }
});
