/* ============================================================
   AtorvaGold.js — Slide 7
   Staggered fade-in: capsule → features → price tag.
   ============================================================ */

$(document).ready(function () {

  gsap.to('.fade-stagger', {
    opacity: 1,
    y: 0,
    duration: 0.9,
    ease: 'power3.out',
    stagger: 0.16,
    delay: 0.25
  });

  gsap.fromTo('.capsule-svg',
    { scale: 0.94, rotate: -2 },
    { scale: 1, rotate: 0, duration: 1.1, ease: 'back.out(1.4)', delay: 0.55 }
  );

  gsap.fromTo('.pellets circle',
    { opacity: 0, scale: 0, transformOrigin: 'center center' },
    { opacity: 1, scale: 1, duration: 0.55, ease: 'back.out(2)', stagger: 0.025, delay: 0.95 }
  );

  gsap.fromTo('.feature-item',
    { opacity: 0, x: 26 },
    { opacity: 1, x: 0, duration: 0.65, ease: 'power2.out', stagger: 0.16, delay: 0.9 }
  );
});
