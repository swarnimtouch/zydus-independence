/* ============================================================
   activity.js — Slides 4, 5, 6 ka combined sequential engine

   PHASE 1  (Slide 4)  : Static folded flag + "Hoist the flag" text.
                         Hover → finger cursor. Click → Phase 2.
   PHASE 2  (Slide 5)  : Audio play, flag → waving animation,
                         Phase-1 text fade-out, photo bubbles spawn & float.
   PHASE 3  (Slide 6)  : Phase-2 start ke exactly 10 second baad —
                         bubbles fade-out & remove, Phase-3 text reveal,
                         Next button show. Waving flag continuous chalta rahega.
   ============================================================ */

 $(document).ready(function () {

  /* ---------- Element references ---------- */
  const $poleImage   = $('#poleImage');
  const $hostGif     = $('#hostGif');
  const $phase1Text  = $('#phase1Text');
  const $phase3Text  = $('#phase3Text');
  const $bubbleTitle = $('#bubblePhaseTitle');
  const $bubblesCont = $('#bubblesContainer');
  const $nextBtn     = $('#activityArrowBtn');
  const $flagHint    = $('#flagClickHint');
  const audioEl      = document.getElementById('bgAudio');
  const hostGifSrc   = $hostGif.data('src');
  const poleOnlySrc  = 'images/pole.png';
  const tabletLandscapeQuery = window.matchMedia('(min-width: 700px) and (orientation: landscape)');
  const finePointerQuery = window.matchMedia('(hover: hover) and (pointer: fine)');
  const coarsePointerQuery = window.matchMedia('(any-pointer: coarse)');
  const noHoverQuery = window.matchMedia('(any-hover: none)');

  syncActivityDeviceClass();
  bindMediaChange(finePointerQuery, syncActivityDeviceClass);
  bindMediaChange(coarsePointerQuery, syncActivityDeviceClass);
  bindMediaChange(noHoverQuery, syncActivityDeviceClass);

  /* ---------- Bubble image pool (assets folder se) ---------- */
  const bubbleImages = [
    'images/bubbles/round_image_01.png',
    'images/bubbles/round_image_02.png',
    'images/bubbles/round_image_03.png',
    'images/bubbles/round_image_04.png',
    'images/bubbles/round_image_05.png',
    'images/bubbles/round_image_06.png',
    'images/bubbles/round_image_07.png',
    'images/bubbles/round_image_08.png',
    'images/bubbles/round_image_09.png',
    'images/bubbles/round_image_10.png',
    'images/bubbles/round_image_11.png',
    'images/bubbles/round_image_12.png',
    'images/bubbles/round_image_13.png',
    'images/bubbles/round_image_14.png',
    'images/bubbles/round_image_15.png'
  ];

  const bubbleLayout = [
    { left: 11, top: 36, size: 116 },
    { left: 34, top: 22, size: 88 },
    { left: 54, top: 13, size: 136 },
    { left: 76, top: 25, size: 122 },
    { left: 45, top: 36, size: 104 },
    { left: 67, top: 47, size: 114 },
    { left: 86, top: 45, size: 82 },
    { left: 28, top: 62, size: 104 },
    { left: 48, top: 63, size: 78 },
    { left: 84, top: 72, size: 146 },
    { left: 15, top: 77, size: 92 },
    { left: 35, top: 84, size: 118 },
    { left: 53, top: 83, size: 112 },
    { left: 69, top: 84, size: 106 },
    { left: 91, top: 64, size: 86 }
  ];

  let phase2Started = false;   // guard: Phase 2 ek hi baar trigger ho
  let nextMode = null;
  let preserveAlignRaf = null;
  let preserveAlignUntil = 0;

  function bindMediaChange(mediaQuery, handler) {
    if (mediaQuery.addEventListener) {
      mediaQuery.addEventListener('change', handler);
    } else if (mediaQuery.addListener) {
      mediaQuery.addListener(handler);
    }
  }

  function isTabletLikeDevice() {
    const ua = navigator.userAgent || '';
    const platform = navigator.platform || '';
    const uaData = navigator.userAgentData || null;
    const uaPlatform = uaData && uaData.platform ? uaData.platform : platform;
    const maxTouchPoints = navigator.maxTouchPoints || 0;
    const hasTouch = maxTouchPoints > 0 || coarsePointerQuery.matches || ('ontouchstart' in window);
    const isiPadOSDesktopUA = platform === 'MacIntel' && maxTouchPoints > 1;
    const isMobileOrTabletUA = /Android|iPad|iPhone|iPod|Mobile|Tablet|Silk|Kindle/i.test(ua) || /Android|iOS|iPadOS/i.test(uaPlatform);
    const tabletSizedTouchScreen = hasTouch && Math.max(window.screen.width || 0, window.screen.height || 0) <= 1600;
    const foldableViewport = hasTouch && Math.max(window.innerWidth, window.innerHeight) <= 1368 && Math.min(window.innerWidth, window.innerHeight) >= 700;

    return Boolean(
      (uaData && uaData.mobile) ||
      isMobileOrTabletUA ||
      isiPadOSDesktopUA ||
      coarsePointerQuery.matches ||
      noHoverQuery.matches ||
      tabletSizedTouchScreen ||
      foldableViewport
    );
  }

  function isDesktopDevice() {
    return finePointerQuery.matches && !isTabletLikeDevice();
  }

  function syncActivityDeviceClass() {
    const tabletDevice = isTabletLikeDevice();
    const desktopDevice = finePointerQuery.matches && !tabletDevice;

    document.body.classList.toggle('activity-tablet-device', tabletDevice);
    document.body.classList.toggle('activity-desktop-device', desktopDevice);
  }

  /* ============================================================
     PHASE 1 — Initial load (Slide 4 state)
     ============================================================ */
  // Pole visible, phase1Text visible.
  // CSS already finger cursor + hint pulse lagata hai.
  // Actual hosting action sirf flag image par rahe.
  $poleImage.on('click', startPhase2);
  $nextBtn.on('click', handleNextClick);

  gsap.to('#phase1Text .text-line', {
    opacity: 1,
    y: 0,
    duration: 1,
    ease: 'power3.out',
    stagger: 0.35,
    delay: 0.4
  });

  setTimeout(function () {
    $('#phase1Text .activity-golden-text').addClass('is-typing');
  }, 1150);


  /* ============================================================
     PHASE 2 — Flag clicked (Slide 5 state)
     ============================================================ */
  /* ============================================================
     PHASE 2 — Flag Clicked: Exactly 15 Seconds Flag + Music Engine
     ============================================================ */
  function startPhase2() {
    if (phase2Started) return;
    phase2Started = true;

    gsap.to($flagHint, {
      opacity: 0,
      y: 12,
      duration: 0.28,
      ease: 'power2.out',
      onComplete: function () {
        $flagHint.addClass('is-hidden');
      }
    });

    $poleImage.attr('src', poleOnlySrc);

    /* 1. Audio Loop ke sath start karo (chhota music ho to auto-repeat hoga) */
    audioEl.currentTime = 0;
    audioEl.loop = true;
    audioEl.play().catch(function (err) {
      console.warn('Audio playback blocked:', err);
    });

    /* 2. Pole ke top-right pe host.gif start karo */
    $hostGif.attr('src', '');
    $hostGif.removeClass('is-hidden');
    $hostGif.attr('src', hostGifSrc + '?start=' + Date.now());
    gsap.set($hostGif, { opacity: 1, scale: 1 });

    setTimeout(function () {
      showNextButton('bubbles');
    }, 4000);
  }

  function handleNextClick(event) {
    if (nextMode === 'continue') {
      return;
    }

    event.preventDefault();

    if (nextMode === 'bubbles') {
      hideNextButton();
      startBubblePhase();
      return;
    }

    if (nextMode === 'final') {
      hideNextButton();
      startPhase3();
    }
  }

  function showNextButton(mode) {
    nextMode = mode;
    $nextBtn.removeClass('is-hidden');
    gsap.fromTo($nextBtn,
      { opacity: 0, y: 20 },
      { opacity: 1, y: 0, duration: 0.55, ease: 'power2.out' }
    );
  }

  function hideNextButton() {
    nextMode = null;
    gsap.set($nextBtn, { opacity: 0, y: 20 });
    $nextBtn.addClass('is-hidden');
  }


  /* ============================================================
     BUBBLE PHASE — Only triggered after 15 Seconds of Flag/Music
     ============================================================ */
  function startBubblePhase() {
    $('body').addClass('activity-bubble-active');
    hideActivityIntroText();
    showBubbleTitle();

    // Bubbles spawn karo
    spawnBubbles();
  }

  function showBubbleTitle() {
    $bubbleTitle.removeClass('is-hidden');
    gsap.fromTo($bubbleTitle,
      { opacity: 0, y: -16 },
      { opacity: 1, y: 0, duration: 0.65, ease: 'power2.out' }
    );
  }

  function hideBubbleTitle() {
    gsap.to($bubbleTitle, {
      opacity: 0,
      y: -12,
      duration: 0.35,
      ease: 'power2.out',
      onComplete: function () {
        $bubbleTitle.addClass('is-hidden');
      }
    });
  }

  function hideActivityIntroText() {
    gsap.to($phase1Text, {
      opacity: 0,
      duration: 0.45,
      ease: 'power2.out',
      onComplete: function () {
        $phase1Text.css({
          visibility: 'hidden',
          pointerEvents: 'none'
        });
      }
    });
  }


  /* ---------- Bubble spawning ---------- */
  function spawnBubbles() {
    const settleTime = 2800;
    const spawnGap = 150;

    bubbleLayout.forEach(function (bubble, i) {
      setTimeout(function () {
        createBubble(i, bubble);
      }, i * spawnGap);
    });

    const allBubblesDisplayedAt = settleTime + bubbleLayout.length * spawnGap;

    setTimeout(startBubbleDrift, allBubblesDisplayedAt);
    setTimeout(function () {
      showNextButton('final');
    }, allBubblesDisplayedAt + 4000);
  }

  function createBubble(index, bubble) {
    const imgSrc = bubbleImages[index % bubbleImages.length];
    const bubbleSize = Math.round(bubble.size * getBubbleScale());
    const safeTopPercent = getBubbleSafeTopPercent(bubbleSize);
    const targetTop = Math.max(bubble.top, safeTopPercent);

    const $b = $('<div class="photo-bubble"></div>');
    $b.css({
      width:           bubbleSize + 'px',
      height:          bubbleSize + 'px',
      left:            '50%',
      top:             '50%',
      backgroundImage: 'url(' + imgSrc + ')'
    });

    $bubblesCont.append($b);

    gsap.fromTo($b,
      { xPercent: -50, yPercent: -50, scale: 0.2, opacity: 0 },
      {
        left: bubble.left + '%',
        top: targetTop + '%',
        xPercent: -50,
        yPercent: -50,
        scale: 1,
        opacity: 1,
        duration: 2.1,
        ease: 'power3.out'
      }
    );
  }

  function getBubbleScale() {
    const width = window.innerWidth;
    if (width <= 420) return 0.46;
    if (width <= 767) return 0.56;
    if (width <= 1024) return 0.76;
    if (width <= 1180) return 0.86;
    return 1;
  }

  function getBubbleSafeTopPercent(bubbleSize) {
    const titleEl = $bubbleTitle[0];
    const viewportHeight = Math.max(window.innerHeight || 0, document.documentElement.clientHeight || 0, 1);
    let titleBottom = 0;

    if (titleEl && !$bubbleTitle.hasClass('is-hidden')) {
      titleBottom = titleEl.getBoundingClientRect().bottom;
    }

    const safeGap = Math.max(18, Math.round(viewportHeight * 0.035));
    const safeTopPx = titleBottom + safeGap + (bubbleSize / 2);

    return Math.min(92, (safeTopPx / viewportHeight) * 100);
  }

  function startBubbleDrift() {
    $('.photo-bubble').each(function (index, bubbleEl) {
      gsap.to(bubbleEl, {
        x: index % 2 === 0 ? 16 : -16,
        y: index % 3 === 0 ? -13 : 13,
        rotate: index % 2 === 0 ? 3 : -3,
        duration: 4.2 + (index % 4) * 0.4,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
      });
    });
  }


  /* ============================================================
     PHASE 3 — 10 seconds after Phase 2 (Slide 6 state)
     ============================================================ */
  function startPhase3() {

    gsap.killTweensOf('.photo-bubble');
    $('body').removeClass('activity-bubble-active');
    hideBubbleTitle();

    /* 3a. Bubbles fade-out → DOM se remove */
    gsap.to('.photo-bubble', {
      opacity: 0,
      duration: 1,
      ease: 'power2.out',
      onComplete: function () {
        $bubblesCont.empty();
      }
    });

    /* 3b. Phase-3 text reveal — modern staggered animation */
    $('body').addClass('activity-final-active');
    $phase3Text.removeClass('is-hidden');
    // Parent container visible
    gsap.set($phase3Text, { opacity: 1 });
    scheduleFinalPreserveAlign(3200);
    $('.final-typewriter-line').removeClass('is-typing is-revealed');
    const finalGoldenText = document.querySelector('.final-golden-text');
    if (finalGoldenText) void finalGoldenText.offsetWidth;
    gsap.set('.final-golden-text', { opacity: 1, y: 0 });
    setTimeout(function () {
      $('.final-golden-line').addClass('is-typing');
      setTimeout(function () {
        $('.final-golden-line').addClass('is-revealed');
      }, 1150);
    }, 950);
    setTimeout(function () {
      $('.final-moments-line').addClass('is-typing');
      setTimeout(function () {
        $('.final-moments-line').addClass('is-revealed');
      }, 1150);
    }, 1800);

    // Children staggered reveal
    gsap.fromTo('.final-animate',
      { opacity: 0, y: 28 },
      {
        opacity: 1,
        y: 0,
        duration: 0.9,
        ease: 'power3.out',
        stagger: 0.4,
        delay: 0.6
      }
    );

    /* 3c. Real continue button show (waving flag continuous chalta rahega) */
    setTimeout(function () {
      scheduleFinalPreserveAlign(1800);
      showNextButton('continue');
    }, 1800);
  }

  function scheduleFinalPreserveAlign(durationMs) {
    if (durationMs) {
      preserveAlignUntil = Math.max(preserveAlignUntil, Date.now() + durationMs);
    }

    if (preserveAlignRaf) {
      cancelAnimationFrame(preserveAlignRaf);
    }

    preserveAlignRaf = requestAnimationFrame(alignFinalPreserveToHost);
  }

  function alignFinalPreserveToHost() {
    preserveAlignRaf = null;

    const finalPanel = $phase3Text[0];
    const hostGif = $hostGif[0];
    const preserve = document.querySelector('.activity-final-preserve');

    if (!finalPanel || !hostGif || !preserve) return;

    if (!tabletLandscapeQuery.matches || !$('body').hasClass('activity-final-active')) {
      finalPanel.style.removeProperty('--final-preserve-center-y');
      return;
    }

    const hostRect = hostGif.getBoundingClientRect();
    const finalRect = finalPanel.getBoundingClientRect();
    const preserveRect = preserve.getBoundingClientRect();

    if (!hostRect.width || !hostRect.height || !finalRect.height) return;

    const safeGap = 6;
    const hostCenterY = hostRect.top + (hostRect.height / 2) - finalRect.top;
    const targetTopY = hostCenterY - (preserveRect.height / 2);
    const minTopY = safeGap;
    const maxTopY = finalRect.height - preserveRect.height - safeGap;
    const preserveTopY = Math.max(minTopY, Math.min(targetTopY, maxTopY));

    finalPanel.style.setProperty('--final-preserve-center-y', preserveTopY + 'px');

    if (Date.now() < preserveAlignUntil) {
      preserveAlignRaf = requestAnimationFrame(alignFinalPreserveToHost);
    }
  }

  $(window).on('resize orientationchange', function () {
    syncActivityDeviceClass();
    scheduleFinalPreserveAlign(700);
  });

  if (window.visualViewport) {
    window.visualViewport.addEventListener('resize', function () {
      scheduleFinalPreserveAlign(700);
    });
    window.visualViewport.addEventListener('scroll', function () {
      scheduleFinalPreserveAlign(700);
    });
  }

});
