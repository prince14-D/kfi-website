<footer class="footer mt-5">
  <div class="container py-5">
    <div class="row g-4">

      <div class="col-lg-4">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="assets/images/logo.png" alt="Kingdom Foundation Institute Logo" width="48" height="48" class="rounded-circle">
          <h5 class="fw-bold mb-0">Kingdom Foundation Institute</h5>
        </div>
        <p class="mb-2">Building strong academic foundations with discipline, creativity, and values.</p>
        <p class="mb-0"><strong>Motto:</strong> Come As A Student, Leave As A Student</p>
      </div>

      <div class="col-6 col-lg-2">
        <h6 class="footer-title">Quick Links</h6>
        <ul class="footer-links list-unstyled mb-0">
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="academics.php">Academics</a></li>
          <li><a href="admission.php">Admission</a></li>
        </ul>
      </div>

      <div class="col-6 col-lg-2">
        <h6 class="footer-title">Explore</h6>
        <ul class="footer-links list-unstyled mb-0">
          <li><a href="director.php">Director</a></li>
          <li><a href="gallery.php">Gallery</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="https://portal.kingdomfoundationinstituteinc.org/login.php" target="_blank">E-Portal</a></li>
        </ul>
      </div>

      <div class="col-lg-4">
        <h6 class="footer-title">Contact Info</h6>
        <p class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i>Diamond Creek Campus, Soul Clinic Community,Paynesville, Liberia</p>
        <p class="mb-2"><i class="bi bi-telephone-fill me-2"></i>(+231)770 372 231</p>
        <p class="mb-3"><i class="bi bi-envelope-fill me-2"></i>info@kingdomfoundationinstituteinc.org</p>

        <div class="footer-social d-flex gap-2">
          <a href="tel:+231770372231" aria-label="Call"><i class="bi bi-telephone-fill"></i></a>
          <a href="mailto:info@kingdomfoundationinstituteinc.org" aria-label="Email"><i class="bi bi-envelope-fill"></i></a>
          <a href="https://wa.me/231770372231" target="_blank" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>

    </div>
  </div>

  <div class="footer-bottom py-3">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
      <small>&copy; <?php echo date("Y"); ?> Kingdom Foundation Institute. All Rights Reserved.</small>
      <small>Developed by <strong><a href="https://www.tecliberia.com" target="_blank" rel="noopener noreferrer" style="color:inherit;">Tec Liberia</a></strong></small>
    </div>
  </div>

  <button id="backToTop" class="back-to-top" aria-label="Back to top">
    <i class="bi bi-arrow-up"></i>
  </button>
</footer>

<!-- ================= SCRIPTS ================= -->

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- ================= SERVICE WORKER ================= -->
<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('service-worker.js')
    .then(() => console.log("Service Worker Registered"))
    .catch(() => console.log("Service Worker Failed"));
}
</script>

<!-- ================= SPLASH SCREEN ================= -->
<script>
window.addEventListener("load", function() {
  setTimeout(function() {
    const splash = document.getElementById("splash-screen");
    if (splash) splash.style.display = "none";
  }, 1200);
});
</script>

<!-- ================= INSTALL PWA ================= -->
<script>
let deferredPrompt;
const installBtn = document.getElementById('installBtn');

window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault();
  deferredPrompt = e;
  if (installBtn) installBtn.style.display = 'inline-block';
});

if (installBtn) {
  installBtn.addEventListener('click', async () => {
    if (deferredPrompt) {
      deferredPrompt.prompt();
      await deferredPrompt.userChoice;
      deferredPrompt = null;
      installBtn.style.display = 'none';
    }
  });
}
</script>

<script src="assets/js/main.js"></script>

</body>
</html>