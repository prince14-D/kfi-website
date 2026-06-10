// Main JS for KFI - add scripts here
document.addEventListener('DOMContentLoaded', function(){
  // Admissions countdown
  var countdown = document.getElementById('countdown');
  if(countdown){
    var deadlineText = countdown.getAttribute('data-deadline');
    var deadline = deadlineText ? new Date(deadlineText) : null;
    var daysEl = document.getElementById('days');
    var hoursEl = document.getElementById('hours');
    var minutesEl = document.getElementById('minutes');
    var secondsEl = document.getElementById('seconds');

    function pad(value){ return String(value).padStart(2, '0'); }

    function updateCountdown(){
      if(!deadline || isNaN(deadline.getTime())){ return; }

      var now = new Date().getTime();
      var distance = deadline.getTime() - now;

      if(distance <= 0){
        [daysEl, hoursEl, minutesEl, secondsEl].forEach(function(el){ if(el){ el.textContent = '00'; } });
        clearInterval(countdownTimer);
        return;
      }

      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      if(daysEl){ daysEl.textContent = pad(days); }
      if(hoursEl){ hoursEl.textContent = pad(hours); }
      if(minutesEl){ minutesEl.textContent = pad(minutes); }
      if(secondsEl){ secondsEl.textContent = pad(seconds); }
    }

    updateCountdown();
    var countdownTimer = setInterval(updateCountdown, 1000);
  }

  // Simple slider autoplay and controls
  var slides = document.querySelectorAll('.hero-slider .slide');
  if (slides.length > 0) {
    var current = 0;
    var nextBtn = document.querySelector('.slider-controls .next');
    var prevBtn = document.querySelector('.slider-controls .prev');
    function show(index){
      slides.forEach(function(s,i){
        s.classList.toggle('active', i===index);
      });
      current = index;
    }
    function next(){ show((current+1) % slides.length); }
    function prev(){ show((current-1+slides.length) % slides.length); }
    var autoplay = setInterval(next, 6000);
    if(nextBtn) nextBtn.addEventListener('click', function(){ clearInterval(autoplay); next(); });
    if(prevBtn) prevBtn.addEventListener('click', function(){ clearInterval(autoplay); prev(); });
  }

  // Floating contact toggle logic
  const toggleButton = document.querySelector(".floating-contact-toggle");
  const floatingContact = document.querySelector(".floating-contact");
  if (toggleButton && floatingContact) {
    toggleButton.addEventListener("click", function() {
      floatingContact.classList.toggle("is-active");
    });
  }

  // Stats section: animate numbers when visible
  var statsSection = document.querySelector('.stats-section');
  if(statsSection){
    var statCards = statsSection.querySelectorAll('.stat-card');

    function animateValue(el, start, end, duration){
      var range = end - start;
      var startTime = null;
      function step(timestamp){
        if(!startTime) startTime = timestamp;
        var progress = Math.min((timestamp - startTime) / duration, 1);
        var value = Math.floor(start + range * progress);
        el.textContent = value + (el.dataset.suffix || '');
        if(progress < 1){
          window.requestAnimationFrame(step);
        }
      }
      window.requestAnimationFrame(step);
    }

    var observer = new IntersectionObserver(function(entries, obs){
      entries.forEach(function(entry){
        if(entry.isIntersecting){
          statCards.forEach(function(card){
            card.classList.add('active');
            var numEl = card.querySelector('h3');
            if(numEl){
              var target = parseInt(numEl.getAttribute('data-target')) || parseInt(numEl.textContent.replace(/\D/g,'')) || 0;
              // preserve non-digit suffix (like + or %)
              var suffix = (numEl.textContent.match(/[^0-9]+$/) || [''])[0] || '';
              numEl.dataset.suffix = suffix;
              // clear display before anim
              numEl.textContent = '0' + suffix;
              animateValue(numEl, 0, target, 1200);
            }
          });
          obs.unobserve(statsSection);
        }
      });
    }, {threshold:0.25});

    observer.observe(statsSection);
  }
});

// Lightbox behavior (outside DOMContentLoaded to reuse existing listeners)
document.addEventListener('click', function(e){
  var link = e.target.closest && e.target.closest('.gallery-link');
  if(link){
    e.preventDefault();
    var src = link.getAttribute('data-src');
    var caption = link.getAttribute('data-caption') || '';
    var lightbox = document.getElementById('lightbox');
    if(!lightbox) return;
    var img = lightbox.querySelector('.lightbox-img');
    var cap = lightbox.querySelector('.lightbox-caption');
    img.src = src;
    img.alt = caption;
    cap.textContent = caption;
    lightbox.setAttribute('aria-hidden','false');
  }

  if(e.target.matches('[data-close], .lightbox-close')){
    var lb = document.getElementById('lightbox');
    if(lb) lb.setAttribute('aria-hidden','true');
  }
});

document.addEventListener('keydown', function(e){
  if(e.key === 'Escape'){
    var lb = document.getElementById('lightbox');
    if(lb) lb.setAttribute('aria-hidden','true');
  }
});

// Admin cards fade-in with stagger
document.addEventListener('DOMContentLoaded', function(){
  // Back to top button logic
  const backToTop = document.getElementById('backToTop');
  if (backToTop) {
    window.addEventListener('scroll', function() {
      if (window.scrollY > 300) {
        backToTop.classList.add('show');
      } else {
        backToTop.classList.remove('show');
      }
    });
    backToTop.addEventListener('click', function() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  var adminSection = document.querySelector('.admin-section');
  if(!adminSection) return;
  var cards = adminSection.querySelectorAll('.admin-card');
  var adminObserver = new IntersectionObserver(function(entries, obs){
    entries.forEach(function(entry){
      if(entry.isIntersecting){
        var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        // reveal header, intro and button
        var title = adminSection.querySelector('.section-title');
        var intro = adminSection.querySelector('.admin-intro');
        var btn = adminSection.querySelector('.btn-school');

        if(title) {
          if(prefersReduced) title.classList.add('is-visible'); else setTimeout(function(){ title.classList.add('is-visible'); }, 80);
        }
        if(intro) {
          if(prefersReduced) intro.classList.add('is-visible'); else setTimeout(function(){ intro.classList.add('is-visible'); }, 160);
        }
        if(btn) {
          if(prefersReduced) btn.classList.add('is-visible'); else setTimeout(function(){ btn.classList.add('is-visible'); }, 240);
        }

        // reveal cards with per-card CSS delay for a smoother stagger
        cards.forEach(function(card, i){
          var delay = prefersReduced ? 0 : i * 120;
          card.style.setProperty('--delay', delay + 'ms');
          card.classList.add('is-visible');
        });
        obs.unobserve(adminSection);
      }
    });
  }, {threshold: 0.18});
  adminObserver.observe(adminSection);
});
