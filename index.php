<?php
require_once 'includes/storage_helper.php';
$home_news = get_recent_news(3);
$home_team = get_featured_team_members(4);
$home_gallery = get_featured_gallery_items(6);
include 'includes/header.php';
?>
<section class="hero-slider">
  <div class="slide active" style="background-image:url('assets/images/banner-slider.jpeg')">
    <div class="overlay"></div>
    <div class="slide-inner container">
      <p class="slide-kicker">Welcome to Kingdom Foundation Institute</p>
      <h1>Building academic excellence and strong Christian character.</h1>
      <p></p>
      <div class="hero-cta">
        <a href="admissions.php" class="hero-btn hero-btn-primary">Apply Now</a>
        <a href="about.php" class="hero-btn hero-btn-secondary">Learn More</a>
      </div>
    </div>
  </div>
  <div class="slide" style="background-image:url('assets/images/banner3.jpeg')">
    <div class="overlay"></div>
    <div class="slide-inner container">
      <p class="slide-kicker">A Learning Environment That Cares</p>
      <h1>Focused teaching and meaningful support</h1>
      <p>Our classrooms are designed to help students build strong foundations and develop the habits needed for success.</p>
      <div class="hero-cta">
        <a href="about.php" class="hero-btn hero-btn-secondary">Discover More</a>
      </div>
    </div>
  </div>
  <div class="slide" style="background-image:url('assets/images/banner-slider1.jpeg')">
    <div class="overlay"></div>
    <div class="slide-inner container">
      <p class="slide-kicker">Join the KFI Community</p>
      <h1>Education grounded in excellence</h1>
      <p>From admission to graduation, we are committed to helping students thrive in a culture of discipline, respect, and achievement.</p>
      <div class="hero-cta">
        <a href="contacts.php" class="hero-btn hero-btn-primary">Contact Us</a>
      </div>
    </div>
  </div>
</section>

<section class="admissions-cta-wrap" data-animate>
  <div class="container-fluid px-0">
    <div class="admissions-cta p-4 p-md-5">
      <div class="row align-items-center g-4 g-lg-5">
        <div class="col-lg-8 text-center text-lg-start">
      <h2 class="section-title text-white">Admissions Now Open</h2>
      <p class="mb-0">Give your child a strong academic and moral foundation in a nurturing school community.</p>

      <div id="countdown" data-deadline="2026-09-30T23:59:59" class="d-flex flex-wrap gap-2 gap-md-3 mt-4 justify-content-center justify-content-lg-start">
        <div class="time-box"><h3 id="days">00</h3><small>Days</small></div>
        <div class="time-box"><h3 id="hours">00</h3><small>Hours</small></div>
        <div class="time-box"><h3 id="minutes">00</h3><small>Minutes</small></div>
        <div class="time-box"><h3 id="seconds">00</h3><small>Seconds</small></div>
      </div>
        </div>

        <div class="col-lg-4 text-center mt-4 mt-lg-0">
          <a href="admissions.php" class="btn btn-school btn-lg w-100 mb-2">Start Application</a>
          <a href="contacts.php" class="btn btn-outline-light btn-lg w-100">Talk To Us</a>
        </div>
      </div>
    </div>
  </div>
</section>
 


<section class="founder-message py-5" data-animate>
  <div class="container py-3">
    <div class="row align-items-center g-4 g-lg-5">
      <div class="col-lg-5">
        <div class="founder-photo-frame">
          <img src="assets/images/founder.jpg" alt="Mrs. Comfort Enders" class="img-fluid founder-photo">
        </div>
      </div>
      <div class="col-lg-7">
        <div class="founder-copy">
          <p class="section-eyebrow">MESSAGE FROM THE FOUNDING PRINCIPAL</p>
          <h2>Mrs. Comfort Enders, M.Ed.</h2>
          <p class="founder-title">Founding Principal/Chief Executive Consultant</p>

          <blockquote class="founder-quote">"At Kingdom Foundation Institute, we are committed modeling and connecting with schools in developing nurturing spaces for responsible Christian leaders for the workplace."</blockquote>
          <p>
            Kingdom Foundation Institute, Inc., under God’s guidance, has lived the reality of a famous saying: “Start by doing what is necessary, then do what is possible, and suddenly you are doing the impossible.”
          </p>
          <p>
            In 1996, it became necessary for one missionary family, in refuge from war, to provide foundational academic preparation for their own 3 children at home, using an international, Christian-based academic curriculum.
          </p>
          <p>
            Then in 2000 it was necessary and possible to secure a Ministry of Education operational permit for an elementary school that would include nearly 100 neighborhood children in our program housed in palm-straw mat buildings at two locations in the community.
          </p>
          <p>
            Now, with the small, necessary, consistent steps, we are at what seemed impossible at the start: The Kingdom Foundation Institute is modeling and connecting with schools in developing nurturing spaces for responsible Christian leaders for the workplace.
          </p>

          <p class="founder-signoff mb-0">With purpose and gratitude,<br><strong>Mrs. Comfort Enders, M.Ed.</strong></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="home-news-section py-5" data-animate>
  <div class="container">
    <div class="section-heading-row">
      <div>
        <span class="section-eyebrow">Latest News</span>
        <h2 class="section-title mb-2">News & Updates</h2>
        <p class="text-muted mb-0">Follow school announcements, student achievements, events, and community updates from KFI.</p>
      </div>
      <a href="news.php" class="btn btn-outline-primary news-view-all">View All News <i class="bi bi-arrow-right-short" aria-hidden="true"></i></a>
    </div>

    <?php if (empty($home_news)): ?>
      <div class="news-empty-state mt-4">No news has been published yet. Please check back soon.</div>
    <?php else: ?>
      <div class="row g-4 mt-1">
        <?php foreach ($home_news as $post): ?>
          <div class="col-md-6 col-lg-4">
            <article class="news-card">
              <a href="news.php" class="news-card-image">
                <img src="<?php echo htmlspecialchars(news_image_url($post['image'] ?? '')); ?>" alt="<?php echo htmlspecialchars($post['title'] ?? 'KFI news'); ?>">
              </a>
              <div class="news-card-body">
                <div class="news-meta">
                  <span><?php echo htmlspecialchars(date('M d, Y', strtotime($post['date'] ?? 'now'))); ?></span>
                  <span><?php echo htmlspecialchars($post['category'] ?? 'Announcement'); ?></span>
                </div>
                <h3><a href="news.php"><?php echo htmlspecialchars($post['title'] ?? 'Untitled news'); ?></a></h3>
                <p><?php echo htmlspecialchars(excerpt_text($post['summary'] ?? '', 135)); ?></p>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="stats-section py-5 text-center text-light" data-animate>
  <div class="container">
    <h2 class="text-white">Our Impact</h2>
    <div class="row g-3 mt-3">
      <div class="col-md-3"><div class="stat-card"><h3 data-target="1996">1996</h3><p>Founded</p></div></div>
      <div class="col-md-3"><div class="stat-card"><h3 data-target="<?php echo date("Y") - 1996; ?>"><?php echo date("Y") - 1996; ?>+</h3><p>Years</p></div></div>
      <div class="col-md-3"><div class="stat-card"><h3 data-target="98">98%</h3><p>Success Rate</p></div></div>
      <div class="col-md-3"><div class="stat-card"><h3 data-target="3">3</h3><p>Academic Levels</p></div></div>
    </div>
  </div>
</section>

<section class="py-5 text-center" data-animate>
  <div class="container">
    <h2 class="section-title">Academic Programs</h2>
    <div class="row g-4 mt-2">
      <div class="col-md-4">
        <div class="program-card">
          <div class="program-icon">🎓</div>
          <h5>K-12 Education</h5>
          <p class="mb-0">Emphasizing learner-centered pedagogy and high academic integrity</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="program-card">
          <div class="program-icon">🤝</div>
          <h5>Science Education</h5>
          <p class="mb-0">"Hands-on-Lab"<br>After-School Science/STEM Club</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="program-card">
          <div class="program-icon">🌍</div>
          <h5>Jolly Phonics</h5>
          <p class="mb-0">K - 3 program at KFI<br>Nationwide Training for Teachers and Administrators<br>Consultancy Services</p>
        </div>
      </div>
    </div>
  </div>
</section>





<section class="gallery-section py-5" data-animate>
  <div class="container text-center">
    <h2 class="section-title">Activities</h2>
    <div class="row g-3 mt-2">
      <?php foreach ($home_gallery as $item): ?>
        <div class="col-md-4">
          <div class="gallery-item">
            <a href="#" class="gallery-link" data-src="<?php echo htmlspecialchars(news_image_url($item['image'] ?? '')); ?>" data-caption="<?php echo htmlspecialchars($item['caption'] ?? $item['title'] ?? 'KFI activity'); ?>">
              <img src="<?php echo htmlspecialchars(news_image_url($item['image'] ?? '')); ?>" class="gallery-img" alt="<?php echo htmlspecialchars($item['title'] ?? 'KFI activity'); ?>">
              <div class="gallery-overlay"><span class="zoom-icon"><i class="bi bi-search"></i></span></div>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <a href="gallery.php" class="btn btn-school mt-4">View Full Gallery</a>
  </div>
</section>

<!-- Lightbox -->
<div id="lightbox" class="lightbox" aria-hidden="true">
  <div class="lightbox-backdrop" data-close></div>
  <div class="lightbox-content">
    <button class="lightbox-close" aria-label="Close">×</button>
    <img src="" alt="" class="lightbox-img">
    <p class="lightbox-caption"></p>
  </div>
</div>



<!-- Video + Why Choose Us -->
<section class="py-5 bg-light" data-animate>
  <div class="container">
    <div class="row g-4 align-items-center">

      <div class="col-lg-6">
        <div class="ratio ratio-16x9 rounded overflow-hidden shadow video-frame">
          <iframe src="https://www.youtube.com/embed/5jzndGSF5iA"
            title="Kingdom Foundation Institute — Introduction"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
        </div>
      </div>

      <div class="col-lg-6">
        <h2 class="section-title mb-1">Why Choose Us?</h2>
        <p class="text-muted mb-4">We model and connect to maintain excellent academic and character education grounded in a biblical worldviewer.</p>

        <div class="why-list">
          <div class="why-list-item d-flex mb-3">
            <div class="why-list-icon flex-shrink-0 me-3"><i class="bi bi-patch-check-fill"></i></div>
            <div>
              <h6 class="mb-1">Quality Academic Programs</h6>
              <p class="mb-0 text-muted">A structured curriculum from Early Childhood through high school.</p>
            </div>
          </div>

          <div class="why-list-item d-flex mb-3">
            <div class="why-list-icon flex-shrink-0 me-3"><i class="bi bi-people-fill"></i></div>
            <div>
              <h6 class="mb-1">Strategic Networking</h6>
              <p class="mb-0 text-muted">Connect with Christian school leaders for peer support, shared resources, referrals, and collaborative problem solving.</p>
            </div>
          </div>

          <div class="why-list-item d-flex mb-3">
            <div class="why-list-icon flex-shrink-0 me-3"><i class="bi bi-shield-fill-check"></i></div>
            <div>
              <h6 class="mb-1">Targeted professional development</h6>
              <p class="mb-0 text-muted">Practical training for teachers, administrators, and school teams focused on classroom excellence and Christian formation.</p>
            </div>
          </div>

          <div class="why-list-item d-flex mb-3">
            <div class="why-list-icon flex-shrink-0 me-3"><i class="bi bi-heart-fill"></i></div>
            <div>
              <h6 class="mb-1">Maintaining models of Christian schooling</h6>
              <p class="mb-0 text-muted">Love, unity, discipline, and peaceful co-existence woven into every lesson.</p>
            </div>
          </div>
        </div>

        <a href="about.php" class="btn btn-school mt-4">Discover More About Us</a>
      </div>

    </div>
  </div>
</section>


<!-- Administration -->
<section class="py-5 admin-section" data-animate>
  <div class="container">
    <h2 class="section-title text-center mb-2">Meet Our Administration</h2>
    <p class="text-center text-muted mb-5 admin-intro">The dedicated leaders who guide our school every day.</p>
    <div class="row g-4 justify-content-center">

      <?php foreach ($home_team as $member): ?>
        <div class="col-12 col-md-4 col-lg-3">
          <div class="admin-card text-center">
            <div class="admin-photo-wrap">
              <img src="<?php echo htmlspecialchars(news_image_url($member['image'] ?? '')); ?>" class="team-photo" alt="<?php echo htmlspecialchars($member['name'] ?? 'Team member'); ?>">
            </div>
            <h6 class="mt-3 mb-1"><?php echo htmlspecialchars($member['name'] ?? 'Team Member'); ?></h6>
            <span class="admin-role"><?php echo htmlspecialchars($member['role'] ?? ''); ?></span>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="col-12 text-center">
        <a href="team.php" class="btn btn-school mt-3">View More Team</a>
      </div>

    </div>
  </div>
</section>


<!-- Testimonials -->
<section class="py-5 testimonials-section" data-animate>
  <div class="container">
    <h2 class="section-title text-center mb-3">Voices from Our Community</h2>
    <div class="row g-4 justify-content-center">

      <div class="col-12 col-md-6 col-lg-3">
        <div class="testimonial-card">
          <div class="testimonial-quote"><i class="bi bi-quote"></i></div>
          <p class="testimonial-text">"The values and discipline taught at Logic School are remarkable. My son has grown so much both academically and in character."</p>
          <div class="testimonial-author d-flex align-items-center gap-3 mt-3">
            <img src="assets/images/logo.png" class="testimonial-avatar" alt="Parent">
            <div>
              <strong>Patience Mataley</strong>
              <small class="d-block text-muted">Parent of Grade 5 Student</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="testimonial-card">
          <div class="testimonial-quote"><i class="bi bi-quote"></i></div>
          <p class="testimonial-text">"I am proud to have my daughter enrolled here. The school genuinely cares about every child and it shows in the results."</p>
          <div class="testimonial-author d-flex align-items-center gap-3 mt-3">
            <img src="assets/images/logo.png" class="testimonial-avatar" alt="Parent">
            <div>
              <strong>Rebecca T. Telo</strong>
              <small class="d-block text-muted">Parent of Kindergarten Student</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="testimonial-card">
          <div class="testimonial-quote"><i class="bi bi-quote"></i></div>
          <p class="testimonial-text">"Our experience at KFI has been exceptional — supportive staff and effective learning strategies."</p>
          <div class="testimonial-author d-flex align-items-center gap-3 mt-3">
            <img src="assets/images/logo.png" class="testimonial-avatar" alt="Parent">
            <div>
              <strong>Samuel K.</strong>
              <small class="d-block text-muted">Parent</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="testimonial-card">
          <div class="testimonial-quote"><i class="bi bi-quote"></i></div>
          <p class="testimonial-text">"Attentive teachers and a safe environment — highly recommended."</p>
          <div class="testimonial-author d-flex align-items-center gap-3 mt-3">
            <img src="assets/images/logo.png" class="testimonial-avatar" alt="Parent">
            <div>
              <strong>Amelia R.</strong>
              <small class="d-block text-muted">Parent</small>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<section class="celsin-services py-5" data-animate>
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-eyebrow">Our Core Services</span>
      <h2 class="section-title">Five Pillars of Christian School Development</h2>
      <p class="text-muted mx-auto mb-0" style="max-width:720px;">CELSIN-KFI helps schools strengthen leadership, instruction, governance, collaboration, and improvement systems through practical support.</p>
    </div>

    <div class="row g-4 justify-content-center">
      <div class="col-md-6 col-xl">
        <article class="celsin-service-card">
          <div class="service-icon"><i class="bi bi-diagram-3" aria-hidden="true"></i></div>
          <h5>K-12 Christian Schools Networking</h5>
          <p>Connect with Christian school leaders for peer support, shared resources, referrals, and collaborative problem solving.</p>
        </article>
      </div>

      <div class="col-md-6 col-xl">
        <article class="celsin-service-card">
          <div class="service-icon"><i class="bi bi-calendar-event" aria-hidden="true"></i></div>
          <h5>Annual Christian Education Summit</h5>
          <p>A yearly gathering for training, worship, planning, leadership renewal, and Christian education collaboration.</p>
        </article>
      </div>

      <div class="col-md-6 col-xl">
        <article class="celsin-service-card">
          <div class="service-icon"><i class="bi bi-clipboard-check" aria-hidden="true"></i></div>
          <h5>School Improvement Consultancy</h5>
          <p>On-site and remote support for schools that need stronger systems, clearer plans, and measurable improvement goals.</p>
        </article>
      </div>

      <div class="col-md-6 col-xl">
        <article class="celsin-service-card">
          <div class="service-icon"><i class="bi bi-award" aria-hidden="true"></i></div>
          <h5>K-12 School Accreditation & Recognition</h5>
          <p>A guided recognition process that helps schools document quality, improve standards, and celebrate progress.</p>
        </article>
      </div>

      <div class="col-md-6 col-xl">
        <article class="celsin-service-card">
          <div class="service-icon"><i class="bi bi-person-workspace" aria-hidden="true"></i></div>
          <h5>Professional Development Training</h5>
          <p>Practical training for teachers, administrators, and school teams focused on classroom excellence and Christian formation.</p>
        </article>
      </div>
    </div>
    <div class="text-center mt-5">
      <a href="academic.php#academic-services" class="btn btn-school btn-lg">
        Explore All Services
        <i class="bi bi-arrow-right-short" aria-hidden="true"></i>
      </a>
    </div>
  </div>
</section>




<!-- DOWNLOADS -->
<section class="py-5 downloads-section" data-animate>
  <div class="container">
    <div class="downloads-wrap">
      <div class="text-center mb-4">
        <h2 class="section-title mb-2">Download Programs Documents</h2>
        <p class="text-muted mb-0">Get the latest brochure and information sheet for admissions and programs.</p>
      </div>
      <div class="row g-4 justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="download-card">
            <div class="download-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
            <h5 class="mb-2">Programs Brochure</h5>
            <p class="mb-3">Overview of our programs, facilities, and student life at Logic-A Demonstration School.</p>
            <a href="assets/files/logic-programs-brochure.pdf" class="btn btn-school" download>
              <i class="bi bi-download me-1"></i> Download Brochure
            </a>
          </div>
        </div>
        <div class="col-md-6 col-lg-5">
          <div class="download-card">
            <div class="download-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
            <h5 class="mb-2">Information Sheet</h5>
            <p class="mb-3">Quick facts on admission process, school calendar, contacts, and key requirements.</p>
            <a href="assets/files/logic-programs-information-sheet.pdf" class="btn btn-outline-secondary" download>
              <i class="bi bi-download me-1"></i> Download Info Sheet
            </a>
          </div>
        </div>
      </div>
      <p class="text-center text-muted small mt-4 mb-0">Need help? Call us at (+231)886-551-719 for assistance.</p>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
