<?php
require_once 'includes/storage_helper.php';
$team_members = get_all_team_members();
$team_groups = ['Board Member', 'Administration', 'Staff', 'Lecturer', 'Teacher'];
include 'includes/header.php';
?>

<section class="team-hero">
  <div class="container">
    <span class="section-eyebrow">Our People</span>
    <h1>Meet Our Dedicated Team</h1>
    <p>Our educators and leaders are committed to nurturing every student's potential and fostering a culture of excellence.</p>
  </div>
</section>

<section class="team-directory-section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-eyebrow">Team Directory</span>
      <h2 class="section-title mb-3">Board, Administration, Staff & Faculty</h2>
      <p class="text-muted mx-auto" style="max-width: 760px;">Explore the people who guide governance, administration, teaching, and student support across KFI.</p>
    </div>

    <ul class="team-filter-pills" role="list">
      <?php foreach ($team_groups as $group): ?>
        <li><a href="#<?php echo strtolower(str_replace(' ', '-', $group)); ?>"><?php echo htmlspecialchars($group); ?></a></li>
      <?php endforeach; ?>
    </ul>

    <?php foreach ($team_groups as $group): ?>
      <?php
        $group_members = array_values(array_filter($team_members, function($member) use ($group) {
          return ($member['person_type'] ?? 'Staff') === $group;
        }));
      ?>
      <?php if (!empty($group_members)): ?>
        <div class="team-group-block" id="<?php echo strtolower(str_replace(' ', '-', $group)); ?>">
          <div class="team-group-heading">
            <span><?php echo htmlspecialchars($group); ?></span>
            <strong><?php echo count($group_members); ?> profile<?php echo count($group_members) === 1 ? '' : 's'; ?></strong>
          </div>
          <div class="row g-4 justify-content-center">
            <?php foreach ($group_members as $index => $member): ?>
              <?php $modal_id = 'teamProfile' . preg_replace('/[^a-zA-Z0-9]/', '', $member['id'] ?? (string)$index); ?>
              <div class="col-md-6 col-xl-4">
                <article class="team-profile-card">
                  <div class="team-profile-image">
                    <img src="<?php echo htmlspecialchars(news_image_url($member['image'] ?? '')); ?>" alt="<?php echo htmlspecialchars($member['name'] ?? 'Team member'); ?>">
                  </div>
                  <div class="team-profile-body">
                    <span class="team-profile-badge"><?php echo htmlspecialchars($member['department'] ?? 'Leadership'); ?></span>
                    <h3><?php echo htmlspecialchars($member['name'] ?? 'Team Member'); ?></h3>
                    <p class="team-profile-role"><?php echo htmlspecialchars($member['role'] ?? ''); ?></p>
                    <p class="team-profile-bio"><?php echo htmlspecialchars(excerpt_text($member['bio'] ?? '', 118)); ?></p>
                    <button type="button" class="btn btn-school team-profile-button" data-bs-toggle="modal" data-bs-target="#<?php echo htmlspecialchars($modal_id); ?>">
                      View Profile
                    </button>
                  </div>
                </article>
              </div>
              <div class="modal fade team-profile-modal" id="<?php echo htmlspecialchars($modal_id); ?>" tabindex="-1" aria-labelledby="<?php echo htmlspecialchars($modal_id); ?>Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="team-modal-grid">
                      <img src="<?php echo htmlspecialchars(news_image_url($member['image'] ?? '')); ?>" alt="<?php echo htmlspecialchars($member['name'] ?? 'Team member'); ?>">
                      <div>
                        <span class="team-profile-badge"><?php echo htmlspecialchars(($member['person_type'] ?? 'Staff') . ' / ' . ($member['department'] ?? 'Leadership')); ?></span>
                        <h3 id="<?php echo htmlspecialchars($modal_id); ?>Label"><?php echo htmlspecialchars($member['name'] ?? 'Team Member'); ?></h3>
                        <p class="team-profile-role"><?php echo htmlspecialchars($member['role'] ?? ''); ?></p>
                        <p class="team-modal-bio"><?php echo nl2br(htmlspecialchars($member['bio'] ?? '')); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>

    <div class="text-center mt-5">
      <a href="about.php" class="btn btn-school btn-lg">
        <i class="bi bi-arrow-left me-2"></i> Back to About Us
      </a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
