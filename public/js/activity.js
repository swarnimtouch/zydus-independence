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
  const $bubblesCont = $('#bubblesContainer');
  const $nextBtn     = $('#activityNextBtn');
  const audioEl      = document.getElementById('bgAudio');
  const hostGifSrc   = $hostGif.data('src');
  const poleOnlySrc  = 'images/pole.png';

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

  /* ============================================================
     PHASE 1 — Initial load (Slide 4 state)
     ============================================================ */
  // Pole visible, phase1Text visible.
  // CSS already finger cursor + hint pulse lagata hai.
  // Click listener lagao:
  $poleImage.on('click', startPhase2);

  gsap.to('#phase1Text .text-line', {
    opacity: 1,
    y: 0,
    duration: 1,
    ease: 'power3.out',
    stagger: 0.35,
    delay: 0.4
  });


  /* ============================================================
     PHASE 2 — Flag clicked (Slide 5 state)
     ============================================================ */
  /* ============================================================
     PHASE 2 — Flag Clicked: Exactly 15 Seconds Flag + Music Engine
     ============================================================ */
  function startPhase2() {
    if (phase2Started) return;
    phase2Started = true;

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
    gsap.fromTo($hostGif,
      { opacity: 0, scale: 0.95 },
      { opacity: 1, scale: 1, duration: 0.45, ease: 'power2.out' }
    );

    /* 4. EXACTLY 15 SECONDS TIMER:
          15 second pure hone ke baad audio rukega aur BUBBLE WALA PART aayega */
    setTimeout(function () {
      // Ab bubble animation start hogi
      startBubblePhase();
    }, 7000);
  }


  /* ============================================================
     BUBBLE PHASE — Only triggered after 15 Seconds of Flag/Music
     ============================================================ */
  function startBubblePhase() {
    hideActivityIntroText();

    // Bubbles spawn karo
    spawnBubbles();
  }

  function hideActivityIntroText() {
    gsap.to($phase1Text, {
      opacity: 0,
      duration: 0.45,
      ease: 'power2.out',
      onComplete: function () {
        $phase1Text.addClass('is-hidden');
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

    setTimeout(startBubbleDrift, settleTime + bubbleLayout.length * spawnGap);
    setTimeout(startPhase3, settleTime + bubbleLayout.length * spawnGap + 15000);
  }

  function createBubble(index, bubble) {
    const imgSrc = bubbleImages[index % bubbleImages.length];
    const bubbleSize = Math.round(bubble.size * getBubbleScale());

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
        top: bubble.top + '%',
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
    $('.final-typewriter-line').removeClass('is-typing');
    const finalGoldenText = document.querySelector('.final-golden-text');
    if (finalGoldenText) void finalGoldenText.offsetWidth;
    gsap.set('.final-golden-text', { opacity: 1, y: 0 });
    setTimeout(function () {
      $('.final-golden-line').addClass('is-typing');
    }, 950);
    setTimeout(function () {
      $('.final-moments-line').addClass('is-typing');
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

    /* 3c. Next button show (waving flag continuous chalta rahega) */
    setTimeout(function () {
      $nextBtn.removeClass('is-hidden');
      // Re-trigger entrance animation
      gsap.fromTo($nextBtn,
        { opacity: 0, y: 20 },
        { opacity: 1, y: 0, duration: 0.8, ease: 'power2.out' }
      );
    }, 1800);
  }

});
