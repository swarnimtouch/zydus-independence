/* ============================================================
   second.js — Slide 2
   GSAP staggered slide-up + fade-in for each text line.
   ============================================================ */

 $(document).ready(function () {

  // Saari text lines aur date-badge dono ko target karega
  gsap.to('#textContainer .text-line, #textContainer .date-badge', {
    opacity: 1,
    y: 0,
    duration: 1,
    ease: 'power3.out',
    stagger: 0.4,
    delay: 0.5
  });

});