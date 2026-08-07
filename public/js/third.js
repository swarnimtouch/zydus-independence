/* ============================================================
   third.js — Slide 3
   High-quality reveal / fade-in for doctor text.
   ============================================================ */

 $(document).ready(function () {

  gsap.fromTo('#doctorTextContainer .text-line',
    { opacity: 0, y: 50 },
    {
      opacity: 1,
      y: 0,
      duration: 1.2,
      ease: 'power2.out',
      stagger: 0.5,
      delay: 0.4
    }
  );

});