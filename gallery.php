<?php
require_once 'includes/storage_helper.php';
$gallery_items = get_all_gallery_items();
include 'includes/header.php';
?>

<section class="gallery-hero">
  <div class="container">
    <span class="section-eyebrow">Campus Life</span>
    <h1>KFI Gallery</h1>
    <p>Moments from school life, events, activities, and the community that makes Kingdom Foundation Institute feel alive.</p>
  </div>
</section>

<section class="gallery-page-section py-5">
  <div class="container">
    <div class="row g-4">
      <?php if (empty($gallery_items)): ?>
        <div class="col-12">
          <div class="news-empty-state">No gallery items have been posted yet.</div>
        </div>
      <?php else: ?>
        <?php foreach ($gallery_items as $item): ?>
          <div class="col-md-6 col-lg-4">
            <article class="gallery-card">
              <a href="#" class="gallery-link" data-src="<?php echo htmlspecialchars(news_image_url($item['image'] ?? '')); ?>" data-caption="<?php echo htmlspecialchars($item['caption'] ?? $item['title'] ?? 'Gallery image'); ?>">
                <img src="<?php echo htmlspecialchars(news_image_url($item['image'] ?? '')); ?>" alt="<?php echo htmlspecialchars($item['title'] ?? 'Gallery image'); ?>">
                <span><i class="bi bi-search"></i></span>
              </a>
              <div class="gallery-card-body">
                <div class="news-meta">
                  <span><?php echo htmlspecialchars(date('M d, Y', strtotime($item['date'] ?? 'now'))); ?></span>
                  <span><?php echo htmlspecialchars($item['category'] ?? 'Campus Life'); ?></span>
                </div>
                <h3><?php echo htmlspecialchars($item['title'] ?? 'Gallery Item'); ?></h3>
                <p><?php echo htmlspecialchars($item['caption'] ?? ''); ?></p>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<div id="lightbox" class="lightbox" aria-hidden="true">
  <div class="lightbox-backdrop" data-close></div>
  <div class="lightbox-content">
    <button class="lightbox-close" aria-label="Close">x</button>
    <img src="" alt="" class="lightbox-img">
    <p class="lightbox-caption"></p>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
