<?php 
include 'includes/header.php'; 
require_once 'includes/storage_helper.php';
$news_items = get_all_news();
?>

<!-- Hero Banner -->
<section class="about-hero" style="background: linear-gradient(135deg, rgba(0,0,57,0.75), rgba(0,0,142,0.75)), url('assets/images/banner2.jpeg') center/cover; color: #fff; padding: 5rem 1rem; text-align: center;">
  <div class="container">
    <h1 class="display-4 fw-bold mb-3">KFI News & Updates</h1>
    <p class="lead" style="max-width: 60ch; margin: 0 auto; font-size: 1.1rem;">Stay informed with the latest happenings, announcements, and achievements from Kingdom Foundation Institute.</p>
  </div>
</section>

<!-- News Listing Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-eyebrow">Our Stories</span>
      <h2 class="fw-bold mb-3" style="color: #000039; font-size: 2.2rem;">Latest News & Events</h2>
      <p class="text-muted mx-auto" style="max-width: 700px;">Discover the vibrant life at KFI, from academic milestones and student achievements to community events and important announcements.</p>
    </div>

    <div class="row g-4">
      <?php if (empty($news_items)): ?>
        <div class="col-12 text-center py-5">
          <p class="text-muted">No news articles found. Check back later!</p>
        </div>
      <?php else: ?>
        <?php foreach ($news_items as $post): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 shadow-sm border-0">
            <img src="assets/images/<?php echo str_replace('assets/images/', '', $post['image']); ?>" class="card-img-top" alt="News Image">
            <div class="card-body">
              <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em;"><?php echo $post['date']; ?> - <?php echo $post['category']; ?></small>
              <h5 class="card-title fw-bold" style="color: #000039;"><?php echo htmlspecialchars($post['title']); ?></h5>
              <p class="card-text text-muted"><?php echo htmlspecialchars($post['summary']); ?></p>
              <a href="#" class="btn btn-link p-0 fw-bold text-decoration-none" style="color: #00008E;">Read More <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
