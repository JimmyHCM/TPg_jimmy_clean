/* =========================================================================
   TPg Admission — premium micro-interactions
   Progressive enhancement only: everything here is cosmetic.
   No form fields, names, actions or submit behaviour are touched.
   ========================================================================= */
(function () {
  'use strict';

  /* ---- 1. Staggered scroll-reveal ----------------------------------- */
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
      // never hide elements already on screen for long — only prep + observe
      el.classList.add('tp-reveal');
      el.style.setProperty('--tp-delay', (Math.min(stagger, 6) * 60) + 'ms');
      stagger++;
      io.observe(el);
    });

    // safety net: if anything is still hidden after 1.6s, show it
    setTimeout(function () {
      document.querySelectorAll('.tp-reveal:not(.tp-in)').forEach(function (el) {
        el.classList.add('tp-in');
      });
    }, 1600);
  }

  /* ---- 2. Button ripple ---------------------------------------------- */
  function initRipple() {
    document.addEventListener('pointerdown', function (e) {
      var btn = e.target.closest('.btn');
      if (!btn || btn.disabled) return;

      var rect = btn.getBoundingClientRect();
      var size = Math.max(rect.width, rect.height);
      var ripple = document.createElement('span');
      ripple.className = 'tp-ripple';
      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
      ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
      btn.appendChild(ripple);
      setTimeout(function () { ripple.remove(); }, 650);
    }, { passive: true });
  }

  /* ---- 3. Sidebar link press feedback -------------------------------- */
  function initSidebar() {
    document.querySelectorAll('.side-nav-link').forEach(function (link) {
      link.addEventListener('pointerdown', function () {
        link.style.transform = 'translateX(3px) scale(.98)';
      }, { passive: true });
      link.addEventListener('pointerup', function () {
        link.style.transform = '';
      }, { passive: true });
    });
  }

  var reduceMotion = window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function boot() {
    if (!reduceMotion) initReveal();
    initRipple();
    initSidebar();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
