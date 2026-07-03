<?php
require_once 'includes/storage_helper.php';

$donation_success = false;
$donation_error = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['donorName'])) {
    $donorName = trim($_POST['donorName'] ?? '');
    $donorEmail = trim($_POST['donorEmail'] ?? '');
    $donationAmount = trim($_POST['donationAmount'] ?? '');
    $donationFund = trim($_POST['donationFund'] ?? '');

    if ($donorName !== '' && $donorEmail !== '' && $donationAmount !== '' && $donationFund !== '') {
        $saved = save_donation($_POST);
        if ($saved) {
            $donation_success = true;
        } else {
            $donation_error = 'Unable to process your donation request. Please try again.';
        }
    } else {
        $donation_error = 'Please fill in all required fields.';
    }
}

include 'includes/header.php';
?>

<section class="donation-hero">
  <div class="container">
    <div class="donation-hero-content text-center">
      <span class="section-eyebrow">Partner With KFI</span>
      <h1>Invest in Christian education and school improvement.</h1>
      <p>Your support strengthens learners, teachers, and partner schools through values-based education.</p>
      <div class="donation-hero-actions justify-content-center">
        <a href="#ways-to-give" class="btn btn-light btn-lg">Ways to Give</a>
        <a href="contacts.php" class="btn btn-outline-light btn-lg">Speak With Us</a>
      </div>
    </div>
  </div>
</section>

<section class="donation-impact-section py-5">
  <div class="container">
    <div class="section-heading-row">
      <div>
        <span class="section-eyebrow">Funding Priorities</span>
        <h2 class="section-title mb-2">Your gift strengthens more than one classroom.</h2>
        <p class="text-muted mb-0">KFI is building a professional Christian education platform that serves students directly while also equipping schools and educators across communities.</p>
      </div>
    </div>

    <div class="row g-4 mt-1">
      <div class="col-md-6 col-lg-3">
        <article class="donation-priority-card">
          <i class="bi bi-mortarboard-fill"></i>
          <h3>Student Access</h3>
          <p>Scholarships and support for families committed to quality, values-based education.</p>
        </article>
      </div>
      <div class="col-md-6 col-lg-3">
        <article class="donation-priority-card">
          <i class="bi bi-person-workspace"></i>
          <h3>Teacher Growth</h3>
          <p>Training, mentoring, and professional development for stronger classroom practice.</p>
        </article>
      </div>
      <div class="col-md-6 col-lg-3">
        <article class="donation-priority-card">
          <i class="bi bi-building-check"></i>
          <h3>Facilities</h3>
          <p>Campus improvements, learning spaces, and resources that support safe instruction.</p>
        </article>
      </div>
      <div class="col-md-6 col-lg-3">
        <article class="donation-priority-card">
          <i class="bi bi-diagram-3-fill"></i>
          <h3>School Network</h3>
          <p>CEDSIN - KFI services that connect Christian schools and support improvement systems.</p>
        </article>
      </div>
    </div>
  </div>
</section>

<section id="ways-to-give" class="donation-method-section py-5">
  <div class="container">
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-5">
        <div class="donation-trust-panel">
          <span class="section-eyebrow">Giving Channels</span>
          <h2>Make a directed contribution.</h2>
          <p>Donors may designate gifts toward student support, teacher development, facilities, school improvement services, or general operations.</p>
          <ul>
            <li>Transparent giving purpose</li>
            <li>Official school account details</li>
            <li>Follow-up confirmation from KFI</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="row g-4">
          <div class="col-md-6">
            <article class="donation-method-card">
              <span><i class="bi bi-bank"></i></span>
              <h3>Bank Transfer</h3>
              <p>Please use a clear reference such as <strong>KFI Donation</strong> and contact the office after sending.</p>
              <dl>
                <dt>Bank Name</dt>
                <dd>Ecobank Liberia</dd>
                <dt>Account Name</dt>
                <dd>Kingdom Foundation Institute</dd>
                <dt>Account Number</dt>
                <dd>0012014820123456</dd>
                <dt>SWIFT Code</dt>
                <dd>ECOCLRLM</dd>
              </dl>
            </article>
          </div>
          <div class="col-md-6">
            <article class="donation-method-card donation-method-accent">
              <span><i class="bi bi-chat-dots-fill"></i></span>
              <h3>Donor Coordination</h3>
              <p>For institutional partnerships, in-kind donations, recurring support, or project-specific giving, our office can coordinate details directly.</p>
              <a href="contacts.php" class="btn btn-school w-100">Contact Donation Office</a>
            </article>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="donation-form-section py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <?php if ($donation_success): ?>
        <div class="donation-success-card">
          <div class="text-center">
            <i class="bi bi-check-circle-fill text-success fs-1 mb-3"></i>
            <h2 class="section-title mb-3">Thank You for Your Generosity!</h2>
            <p class="lead mb-4">Your donation request has been received. We'll be in touch shortly with payment details.</p>
            <div class="donation-next-steps">
              <h5>Next Steps</h5>
              <ul class="list-unstyled">
                <li><i class="bi bi-whatsapp text-success me-2"></i> Chat with us on WhatsApp for immediate assistance: <a href="https://wa.me/231770143081" target="_blank" class="btn btn-success btn-sm mt-2"><i class="bi bi-whatsapp me-1"></i> Contact Us on WhatsApp</a></li>
                <li class="mt-3"><i class="bi bi-envelope text-primary me-2"></i> Or wait for an email from us with payment instructions.</li>
              </ul>
            </div>
            <a href="index.php" class="btn btn-school mt-4">Return to Home</a>
          </div>
        </div>
        <?php else: ?>
        <div class="donation-form-card">
          <?php if ($donation_error): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($donation_error); ?></div>
          <?php endif; ?>
          <div class="text-center mb-4">
            <span class="section-eyebrow">Give Online</span>
            <h2 class="section-title mb-2">Make a Donation</h2>
            <p class="text-muted">Complete the form below and we'll follow up with payment details.</p>
          </div>
          <form id="donationForm" class="donation-form" method="POST" action="donate.php">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="donorName" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="donorName" name="donorName" placeholder="Your full name" required>
              </div>
              <div class="col-md-6">
                <label for="donorEmail" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="donorEmail" name="donorEmail" placeholder="your.email@example.com" required>
              </div>
              <div class="col-md-6">
                <label for="donorPhone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="donorPhone" name="donorPhone" placeholder="+231 XXX XXX XXX">
              </div>
              <div class="col-md-6">
                <label for="donationAmount" class="form-label">Donation Amount (USD) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="donationAmount" name="donationAmount" placeholder="0.00" min="1" step="0.01" required>
                </div>
              </div>
              <div class="col-12">
                <label for="donationFund" class="form-label">Designation <span class="text-danger">*</span></label>
                <select class="form-select" id="donationFund" name="donationFund" required>
                  <option value="" selected disabled>Select a fund...</option>
                  <option value="student-support">Student Support & Scholarships</option>
                  <option value="teacher-development">Teacher Development</option>
                  <option value="facilities">Facilities & Campus Improvements</option>
                  <option value="school-network">School Network (CEDSIN - KFI)</option>
                  <option value="general-operations">General Operations</option>
                </select>
              </div>
              <div class="col-12 mt-3">
                <div class="d-grid gap-2 d-md-flex justify-content-md-between align-items-center">
                  <button type="submit" class="btn btn-school btn-lg">
                    <i class="bi bi-heart-fill me-2"></i>Submit Donation Request
                  </button>
                  <small class="text-muted">You'll receive follow-up with payment instructions</small>
                </div>
              </div>
            </div>
          </form>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<section class="donation-cta-band">
  <div class="container">
    <div class="donation-cta-panel">
      <div>
        <span class="section-eyebrow">Stewardship</span>
        <h2>Thank you for helping build a stronger education future.</h2>
        <p>Every gift helps KFI serve students with excellence and expand practical support for Christian schools.</p>
      </div>
      <a href="contacts.php" class="btn btn-light btn-lg">Start a Giving Conversation</a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
