/* ============================================================
   second.js — Slide 2
   GSAP staggered slide-up + fade-in for each text line.
   ============================================================ */

 $(document).ready(function () {

  const $lines = $('#textContainer .text-line');
  const $introLine = $lines.eq(0);
  const $goldenLine = $lines.eq(1);
  const $historyLine = $lines.eq(2);
  const $dateBadge = $('#textContainer .date-badge');
  let goldenTypingStartedAt = 0;

  function parseAnimationTime(value) {
    return value.split(',')
      .map(function (item) {
        item = item.trim();
        return item.endsWith('ms') ? parseFloat(item) : parseFloat(item) * 1000;
      })
      .filter(function (time) {
        return Number.isFinite(time);
      });
  }

  function getGoldenTypingDuration($line) {
    let maxDuration = 1750;

    $line.find('.golden-word').each(function () {
      const styles = window.getComputedStyle(this);
      const durations = parseAnimationTime(styles.animationDuration);
      const delays = parseAnimationTime(styles.animationDelay);
      const longest = durations.reduce(function (max, duration, index) {
        return Math.max(max, duration + (delays[index] || delays[0] || 0));
      }, 0);

      maxDuration = Math.max(maxDuration, longest);
    });

    return maxDuration + 80;
  }

  function afterGoldenTyping(callback) {
    const elapsed = goldenTypingStartedAt ? performance.now() - goldenTypingStartedAt : 0;
    const waitMs = Math.max(0, getGoldenTypingDuration($goldenLine) - elapsed);

    setTimeout(callback, waitMs);
  }

  gsap.set([$introLine, $goldenLine, $historyLine, $dateBadge], { opacity: 0, y: 40 });

  const timeline = gsap.timeline({ delay: 0.45 });

  timeline
    .to($introLine, {
      opacity: 1,
      y: 0,
      duration: 0.75,
      ease: 'power3.out'
    })
    .to($goldenLine, {
      opacity: 1,
      y: 0,
      duration: 0.45,
      ease: 'power2.out',
      onStart: function () {
        goldenTypingStartedAt = performance.now();
        $goldenLine.addClass('is-typing');
      },
      onComplete: function () {
        afterGoldenTyping(function () {
          gsap.to($historyLine, {
            opacity: 1,
            y: 0,
            duration: 0.7,
            ease: 'power3.out',
            onComplete: function () {
              gsap.to($dateBadge, {
                opacity: 1,
                y: 0,
                duration: 0.65,
                ease: 'power3.out',
                delay: 0.15
              });
            }
          });
        });
      }
    }, '+=0.12');

});
