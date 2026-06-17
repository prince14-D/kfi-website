<?php
require_once 'includes/storage_helper.php';
$news_items = get_all_news();
include 'includes/header.php';
?>

<section class="news-hero">
  <div class="container">
    <span class="section-eyebrow">Newsroom</span>
    <h1>KFI News & Updates</h1>
    <p>Stay informed with the latest happenings, announcements, achievements, and community stories from Kingdom Foundation Institute.</p>
  </div>
</section>

<section class="news-listing-section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-eyebrow">Our Stories</span>
      <h2 class="section-title">Latest News & Events</h2>
      <p class="text-muted mx-auto mb-0" style="max-width: 700px;">Discover the vibrant life at KFI, from academic milestones and student achievements to community events and important announcements.</p>
    </div>

    <div class="row g-4">
      <?php if (empty($news_items)): ?>
        <div class="col-12">
          <div class="news-empty-state">No news articles found. Check back later.</div>
        </div>
      <?php else: ?>
        <?php foreach ($news_items as $post): ?>
          <div class="col-md-6 col-lg-4">
            <article class="news-card news-card-large">
              <div class="news-card-image">
                <img src="<?php echo htmlspecialchars(news_image_url($post['image'] ?? '')); ?>" alt="<?php echo htmlspecialchars($post['title'] ?? 'KFI news'); ?>">
              </div>
              <div class="news-card-body">
                <div class="news-meta">
                  <span><?php echo htmlspecialchars(date('M d, Y', strtotime($post['date'] ?? 'now'))); ?></span>
                  <span><?php echo htmlspecialchars($post['category'] ?? 'Announcement'); ?></span>
                </div>
                <h3><?php echo htmlspecialchars($post['title'] ?? 'Untitled news'); ?></h3>
                <p><?php echo htmlspecialchars($post['summary'] ?? ''); ?></p>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="facebook-section py-5 bg-light">
  <div class="container">
    <div class="text-center mb-4">
      <span class="section-eyebrow">Follow Us</span>
      <h2 class="section-title">Connect on Facebook</h2>
      <p class="text-muted mx-auto mb-0" style="max-width: 600px;">Follow our Facebook page for the latest updates, photos, and community highlights.</p>
    </div>
    <div class="facebook-embed-wrapper text-center">
      <iframe 
        src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fourarena&tabs=timeline&width=500&height=600&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" 
        width="500" 
        height="600" 
        style="border:none;overflow:hidden" 
        scrolling="no" 
        frameborder="0" 
        allowfullscreen="true" 
        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
      </iframe>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
