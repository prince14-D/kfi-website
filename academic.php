<?php include 'includes/header.php'; ?>

<section class="about-hero celsin-page-hero">
  <div class="container">
    <span class="section-eyebrow">CEDSIN - KFI</span>
    <h1 class="display-4 fw-bold mb-3">Christian Education Development and School Improvement Network (CEDSIN - KFI) </h1>
    <p class="lead">Building bright futures through quality academic and Christian character development in the K-12 program.</p>
  </div>
</section>

<section class="celsin-services py-5" id="academic-services">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-eyebrow">Services</span>
      <h2 class="section-title">Four service pillars</h2>
      <p class="text-muted mx-auto mb-0" style="max-width:720px;">CEDSIN - KFI models and helps schools strengthen leadership, instruction, governance, collaboration, and improvement systems through practical support across the four pillars.</p>
    </div>

    <div class="row g-4">
      <div class="col-md-6 col-xl">
        <article class="celsin-service-card">
          <div class="service-icon"><i class="bi bi-diagram-3" aria-hidden="true"></i></div>
          <h5>K-12 Model</h5>
          <p>Excellent space and practice for academic and character growth with a Christian worldview.</p>
        </article>
      </div>

      <div class="col-md-6 col-xl">
        <article class="celsin-service-card">
          <div class="service-icon"><i class="bi bi-calendar-event" aria-hidden="true"></i></div>
          <h5>Schools Network</h5>
          <p>Sharing with and collaborating in best practices in Christian ethical practice.</p>
        </article>
      </div>

      <div class="col-md-6 col-xl">
        <article class="celsin-service-card">
          <div class="service-icon"><i class="bi bi-clipboard-check" aria-hidden="true"></i></div>
          <h5>Training Institutes</h5>
          <p>Equipping with evidence-based, research-grounded tools and resources.</p>
        </article>
      </div>

      <div class="col-md-6 col-xl">
        <article class="celsin-service-card">
          <div class="service-icon"><i class="bi bi-award" aria-hidden="true"></i></div>
          <h5>Consultancy</h5>
          <p>Supporting, monitoring, enhancing excellent practice.</p>
        </article>
      </div>
    </div>
  </div>
</section>

<section class="celsin-fees py-5" id="fees">
  <div class="container">
    <div class="row g-5 align-items-start">
      <div class="col-lg-5">
        <span class="section-eyebrow">Fees Structure</span>
        <h2 class="section-title">Flexible charges based on service package</h2>
        <p class="text-muted">CEDSIN - KFI charges are structured by school size, service type, training length, and whether support is delivered on campus or remotely. Contact the Admissions Office for an official quotation.</p>
        <div class="fees-note">
          <i class="bi bi-info-circle" aria-hidden="true"></i>
          <span>Group training, network membership, summit participation, and consultancy packages are quoted separately.</span>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="table-responsive celsin-fee-table-wrap">
          <table class="table celsin-fee-table mb-0">
            <thead>
              <tr>
                <th>Service</th>
                <th>Best For</th>
                <th>Fee Basis</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>K-12 Model</td>
                <td>K-12 Christian schools</td>
                <td>Program support package</td>
              </tr>
              <tr>
                <td>Schools Network</td>
                <td>School leaders and teachers</td>
                <td>Network participation package</td>
              </tr>
              <tr>
                <td>Training Institutes</td>
                <td>Teachers and administrators</td>
                <td>Per workshop, day, or training package</td>
              </tr>
              <tr>
                <td>Consultancy</td>
                <td>Schools needing guided improvement</td>
                <td>By assessment scope and support period</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="celsin-cta-band">
  <div class="container">
    <div class="celsin-download-panel">
      <div>
        <span class="section-eyebrow">Get Started</span>
        <h2>Bring CEDSIN - KFI support to your school</h2>
        <p>Download the brochure, review the four pillars, and register your interest with the CEDSIN - KFI office.</p>
      </div>
      <div class="celsin-cta-actions">
        <a href="assets/files/celsin-kfi-brochure.html" class="btn btn-light btn-lg" download>
          <i class="bi bi-file-earmark-arrow-down me-1" aria-hidden="true"></i>
          Download Brochure
        </a>
        <a href="#celsin-register" class="btn btn-danger-school btn-lg">Register Now</a>
      </div>
    </div>
  </div>
</section>

<section class="celsin-register py-5" id="celsin-register">
  <div class="container">
    <div class="row g-5 align-items-start">
      <div class="col-lg-7">
        <span class="section-eyebrow">Register Now</span>
        <h2 class="section-title">Submit your school interest</h2>
        <p class="text-muted">Complete the form below to register your school's interest with the CEDSIN - KFI office.</p>

        <?php if (isset($_GET['success']) && $_GET['success'] === '1'): ?>
        <div class="alert alert-success">
          <h4 class="alert-heading"><i class="bi bi-check-circle me-2"></i>Thank You!</h4>
          <p class="mb-0">Kindly wait for a call or message from the team. We appreciate your interest in CEDSIN - KFI and will be in touch soon!</p>
        </div>
        <?php else: ?>
        
        <form class="celsin-form" action="admin/index.php" method="post">
          <input type="hidden" name="submit_celsin_registration" value="1">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="schoolName" class="form-label">School Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="schoolName" name="school_name" required>
            </div>
            <div class="col-md-6">
              <label for="contactName" class="form-label">Contact Person <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="contactName" name="contact_name" required>
            </div>
            <div class="col-md-6">
              <label for="contactEmail" class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="contactEmail" name="contact_email" required>
            </div>
            <div class="col-md-6">
              <label for="contactPhone" class="form-label">Phone / WhatsApp <span class="text-danger">*</span></label>
              <input type="tel" class="form-control" id="contactPhone" name="contact_phone" required>
            </div>
            <div class="col-md-6">
              <label for="schoolType" class="form-label">Service Interest <span class="text-danger">*</span></label>
              <select class="form-select" id="schoolType" name="service_interest" required>
                <option value="">Choose a service</option>
                <option>K-12 Model</option>
                <option>Schools Network</option>
                <option>Training Institutes</option>
                <option>Consultancy</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="schoolSize" class="form-label">School Size</label>
              <select class="form-select" id="schoolSize" name="school_size">
              <option value="">Select school size</option> 
              <option>Under 100 students</option>
                <option>100 - 300 students</option>
                <option>301 - 600 students</option>
                <option>600+ students</option>
              </select>
            </div>
            <div class="col-12">
              <label for="message" class="form-label">Message</label>
              <textarea class="form-control" id="message" name="message" rows="4" placeholder="Tell us what support your school needs."></textarea>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-school btn-lg">Submit Registration Interest</button>
            </div>
          </div>
        </form>
        <?php endif; ?>
      </div>

      <div class="col-lg-5">
        <aside class="admission-office-card">
          <span class="section-eyebrow">Admissions Office</span>
          <h3>Contact CEDSIN - KFI</h3>
          <p>For fees, registration, partnership requests, or training schedules, contact the office directly.</p>

          <div class="office-contact-list">
            <a href="mailto:info@kingdomfoundationinstituteinc.org">
              <i class="bi bi-envelope-fill" aria-hidden="true"></i>
              <span>info@kingdomfoundationinstituteinc.org</span>
            </a>
            <a href="tel:+231770372231">
              <i class="bi bi-telephone-fill" aria-hidden="true"></i>
              <span>+231 770 372 231</span>
            </a>
            <a href="https://wa.me/231770372231" target="_blank" rel="noopener noreferrer">
              <i class="bi bi-whatsapp" aria-hidden="true"></i>
              <span>WhatsApp Admissions Office</span>
            </a>
          </div>

          <div class="office-hours">
            <strong>Office Support</strong>
            <span>Registration guidance, fee quotation, brochure requests, and program placement.</span>
          </div>
        </aside>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
