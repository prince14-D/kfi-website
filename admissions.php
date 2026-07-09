<?php
require_once 'includes/storage_helper.php';
$application_success = '';
$application_error = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['submit_application'])) {
  $required_fields = ['student_name', 'grade', 'parent_name', 'phone'];
  $missing_fields = array_filter($required_fields, function($field) {
    return trim($_POST[$field] ?? '') === '';
  });

  if (!empty($missing_fields)) {
    $application_error = 'Please complete the required fields before submitting.';
  } else {
    $saved = save_admission_application($_POST);
    $application_success = $saved ? 'Thank you. Your admission inquiry has been submitted successfully.' : '';
    $application_error = $saved ? '' : 'We could not save your application right now. Please call the admissions office.';
  }
}

include 'includes/header.php';
?>

<!-- Hero Banner -->
<section class="about-hero" style="background: linear-gradient(135deg, rgba(0,0,57,0.75), rgba(0,0,142,0.75)), url('assets/images/banner2.jpeg') center/cover; color: #fff; padding: 5rem 1rem; text-align: center;">
  <div class="container">
    <h1 class="display-4 fw-bold mb-3">Join the KFI Model (K-12) in the Soul Clinic Community </h1>
    <p class="lead" style="max-width: 60ch; margin: 0 auto; font-size: 1.1rem;">We welcome students from all backgrounds to join our community of academic excellence with christian character development.</p>
  </div>
</section>

<!-- Admission Process -->
<section class="py-5" style="background: #ffffff;">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-eyebrow">The Journey Starts Here</span>
      <h2 class="fw-bold mb-3" style="color: #000039; font-size: 2.2rem;">Admissions Process</h2>
      <p class="text-muted mx-auto" style="max-width: 600px;">Enrolling your child at Kingdom Foundation Institute is a straightforward process designed to ensure a good fit for both the student and the school.</p>
    </div>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="p-4 rounded-4 shadow-sm border-top border-4 h-100 text-center" style="background: #f8fbff; border-color: #00008E !important;">
          <div class="fs-1 mb-3">📝</div>
          <h5 class="fw-bold" style="color: #000039;">1. Application</h5>
          <p class="text-muted">Pick up an application form from our campus or contact our admissions office. Submit the completed form with all necessary documentation.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 rounded-4 shadow-sm border-top border-4 h-100 text-center" style="background: #f8fbff; border-color: #00008E !important;">
          <div class="fs-1 mb-3">🧐</div>
          <h5 class="fw-bold" style="color: #000039;">2. Evaluation</h5>
          <p class="text-muted">Prospective students undergo a placement assessment to help us understand their academic standing and ensure they are placed in the right level.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 rounded-4 shadow-sm border-top border-4 h-100 text-center" style="background: #f8fbff; border-color: #00008E !important;">
          <div class="fs-1 mb-3">🏫</div>
          <h5 class="fw-bold" style="color: #000039;">3. Enrollment</h5>
          <p class="text-muted">Once accepted, finalize the registration by paying the required fees. We will then provide you with everything needed to start the school year.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Requirements & Deadlines -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6">
        <h2 class="fw-bold mb-4" style="color: #000039;">Entry Requirements</h2>
        <p class="mb-4 text-muted">Please ensure you have the following documents ready when submitting your application:</p>
        <ul class="list-unstyled">
          <li class="mb-3 d-flex align-items-start gap-3">
            <i class="bi bi-check-circle-fill" style="color: #00008E;"></i>
            <span>Completed Application Form</span>
          </li>
          <li class="mb-3 d-flex align-items-start gap-3">
            <i class="bi bi-check-circle-fill" style="color: #00008E;"></i>
            <span>Two (2) Recent Passport Photos</span>
          </li>
          <li class="mb-3 d-flex align-items-start gap-3">
            <i class="bi bi-check-circle-fill" style="color: #00008E;"></i>
            <span>Birth Certificate (Original and Photocopy)</span>
          </li>
          <li class="mb-3 d-flex align-items-start gap-3">
            <i class="bi bi-check-circle-fill" style="color: #00008E;"></i>
            <span>Previous School Progress Report or Transcript</span>
          </li>
          <li class="mb-3 d-flex align-items-start gap-3">
            <i class="bi bi-check-circle-fill" style="color: #00008E;"></i>
            <span>Health/Immunization Record (for Early Childhood)</span>
          </li>
        </ul>
      </div>
      <div class="col-lg-6">
        <div class="p-5 rounded-4 text-white" style="background: linear-gradient(135deg, #00008E, #000039); box-shadow: 0 20px 40px rgba(0,0,57,0.2);">
          <h3 class="fw-bold mb-3">Academic Year 2025/2026</h3>
          <p class="mb-4 opacity-75">Admissions are currently open for all levels. We encourage parents to apply early as spaces fill up quickly.</p>
          <div class="mb-4">
            <div class="d-flex align-items-center gap-3 mb-2">
              <i class="bi bi-calendar-check fs-4"></i>
              <span><strong>Main Intake:</strong> September 2025</span>
            </div>
            <div class="d-flex align-items-center gap-3">
              <i class="bi bi-clock fs-4"></i>
              <span><strong>Office Hours:</strong> Mon - Fri, 8:00 AM - 4:00 PM</span>
            </div>
          </div>
          <a href="#admission-form" class="btn btn-warning w-100 py-3 fw-bold">Start Online Inquiry</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="admission-form" class="admission-form-section py-5">
  <div class="container">
    <div class="row g-4 align-items-start">
      <div class="col-lg-5">
        <span class="section-eyebrow">Apply Online</span>
        <h2 class="section-title mb-3">Admission Inquiry Form</h2>
        <p class="text-muted">Share your student and parent details with our admissions office. A staff member will follow up with the next steps and required documents.</p>
        <div class="admission-form-note">
          <i class="bi bi-shield-check"></i>
          <span>Your submission goes directly to the school admin dashboard for review.</span>
        </div>
      </div>
      <div class="col-lg-7">
        <form method="post" class="admission-form-card">
          <?php if ($application_success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($application_success); ?></div>
          <?php endif; ?>
          <?php if ($application_error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($application_error); ?></div>
          <?php endif; ?>

          <div class="row g-3">
            <div class="col-md-6">
              <label for="student_name" class="form-label">Student Name *</label>
              <input type="text" name="student_name" id="student_name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="grade" class="form-label">Grade Applying For *</label>
              <select name="grade" id="grade" class="form-select" required>
                <option value="">Select grade</option>
                <option>Early Childhood</option>
                <option>Kindergarten</option>
                <option>Grade 1</option>
                <option>Grade 2</option>
                <option>Grade 3</option>
                <option>Grade 4</option>
                <option>Grade 5</option>
                <option>Grade 6</option>
                <option>Junior High</option>
                <option>Senior High</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="dob" class="form-label">Date of Birth</label>
              <input type="date" name="dob" id="dob" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="previous_school" class="form-label">Previous School</label>
              <input type="text" name="previous_school" id="previous_school" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="parent_name" class="form-label">Parent/Guardian Name *</label>
              <input type="text" name="parent_name" id="parent_name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="phone" class="form-label">Phone Number *</label>
              <input type="tel" name="phone" id="phone" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="col-12">
              <label for="message" class="form-label">Additional Notes</label>
              <textarea name="message" id="message" class="form-control" rows="4"></textarea>
            </div>
          </div>
          <button type="submit" name="submit_application" class="btn btn-school btn-lg w-100 mt-4">Submit Inquiry</button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Contact Office Section -->
<section class="py-5">
  <div class="container text-center">
    <h2 class="section-title">Need Assistance?</h2>
    <p class="text-muted mb-5">Our admissions team is here to guide you through the process.</p>
    <div class="row justify-content-center g-4">
      <div class="col-md-4">
        <div class="p-4 border rounded-3">
          <h5 class="fw-bold mb-2">Call Admissions</h5>
          <a href="tel:+231770372231" class="text-decoration-none fs-5 fw-bold" style="color: #00008E;">+231 770 372 231</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 border rounded-3">
          <h5 class="fw-bold mb-2">Email Us</h5>
          <a href="mailto:info@kingdomfoundationinstituteinc.org" class="text-decoration-none fs-6 fw-bold" style="color: #00008E;">info@kingdomfoundationinstituteinc.org</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
