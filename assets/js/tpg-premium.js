/* =========================================================================
   TPg Admission — premium micro-interactions (v3 — gallery-calm edition)
   Progressive enhancement only: everything here is cosmetic.
   Interactions are color/opacity only — no transforms, no ripples.
   No form fields, names, actions or submit behaviour are touched.
   ========================================================================= */
(function () {
  'use strict';

  /* Staggered fade-in as content enters the viewport */
  function initReveal() {
    if (!('IntersectionObserver' in window)) return;

    var targets = document.querySelectorAll(
      '.content-page .card, .content-page .list-group-item, .page-title-box'
    );
    if (!targets.length) return;

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('tp-in');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

    var stagger = 0;
    targets.forEach(function (el) {
      el.classList.add('tp-reveal');
      el.style.setProperty('--tp-delay', (Math.min(stagger, 5) * 50) + 'ms');
      stagger++;
      io.observe(el);
    });

    // safety net: if anything is still hidden after 1.5s, show it
    setTimeout(function () {
      document.querySelectorAll('.tp-reveal:not(.tp-in)').forEach(function (el) {
        el.classList.add('tp-in');
      });
    }, 1500);
  }

  var reduceMotion = window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function boot() {
    if (!reduceMotion) initReveal();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
