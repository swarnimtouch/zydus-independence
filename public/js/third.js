/* ============================================================
   third.js — Slide 3
   High-quality reveal / fade-in for doctor text.
   ============================================================ */

 $(document).ready(function () {

  const $lines = $('#doctorTextContainer .text-line');
  const $doctorLine = $lines.eq(0);
  const $reliveLine = $lines.eq(1);
  const $goldenLine = $lines.eq(2);

  gsap.set($lines, { opacity: 0, y: 50 });

  const timeline = gsap.timeline({ delay: 0.4 });

  timeline
    .to($doctorLine, {
      opacity: 1,
      y: 0,
      duration: 0.7,
      ease: 'power2.out'
    })
    .to($reliveLine, {
      opacity: 1,
      y: 0,
      duration: 0.7,
      ease: 'power2.out'
    }, '+=0.12')
    .to($goldenLine, {
      opacity: 1,
      y: 0,
      duration: 0.45,
      ease: 'power2.out',
      onStart: function () {
        $goldenLine.addClass('is-typing');
      }
    }, '+=0.12');

});
