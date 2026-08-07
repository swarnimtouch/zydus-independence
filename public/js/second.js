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
        $goldenLine.addClass('is-typing');
      }
    }, '+=0.12')
    .to($historyLine, {
      opacity: 1,
      y: 0,
      duration: 0.7,
      ease: 'power3.out'
    }, '+=1.45')
    .to($dateBadge, {
      opacity: 1,
      y: 0,
      duration: 0.65,
      ease: 'power3.out'
    }, '+=0.15');

});
