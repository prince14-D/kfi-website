<?php
if (!is_dir('/tmp/kfi_sessions')) {
    mkdir('/tmp/kfi_sessions', 0775, true);
}
session_save_path('/tmp/kfi_sessions');
session_start();

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../includes/storage_helper.php';

$success = '';
$error = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (isset($_POST['delete_news'])) {
        $success = delete_news_item($_POST['news_id'] ?? '') ? 'News article deleted.' : '';
        $error = $success ? '' : 'Unable to delete the article.';
    }

    if (isset($_POST['delete_team'])) {
        $success = delete_team_member($_POST['team_id'] ?? '') ? 'Team member deleted.' : '';
        $error = $success ? '' : 'Unable to delete the team member.';
    }

    if (isset($_POST['delete_gallery'])) {
        $success = delete_gallery_item($_POST['gallery_id'] ?? '') ? 'Gallery post deleted.' : '';
        $error = $success ? '' : 'Unable to delete the gallery post.';
    }

    if (isset($_POST['post_news'])) {
        $title = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');

        if ($title === '' || $summary === '') {
            $error = 'Please add a news headline and summary before publishing.';
        } else {
            $success = save_news_item([
                'title' => $title,
                'date' => $_POST['date'] ?: date('Y-m-d'),
                'category' => $_POST['category'] ?? 'Announcement',
                'summary' => $summary,
                'image' => $_POST['image'] ?? '',
            ]) ? 'News article published successfully.' : '';
            $error = $success ? '' : 'Unable to save the news article.';
        }
    }

    if (isset($_POST['post_team'])) {
        $name = trim($_POST['name'] ?? '');
        $role = trim($_POST['role'] ?? '');

        if ($name === '' || $role === '') {
            $error = 'Please add the team member name and role.';
        } else {
            $success = save_team_member($_POST) ? 'Team member added successfully.' : '';
            $error = $success ? '' : 'Unable to save the team member.';
        }
    }

    if (isset($_POST['post_gallery'])) {
        $title = trim($_POST['gallery_title'] ?? '');

        if ($title === '') {
            $error = 'Please add a gallery title.';
        } else {
            $success = save_gallery_item([
                'title' => $title,
                'category' => $_POST['gallery_category'] ?? 'Campus Life',
                'date' => $_POST['gallery_date'] ?: date('Y-m-d'),
                'caption' => $_POST['caption'] ?? '',
                'image' => $_POST['gallery_image'] ?? '',
            ]) ? 'Gallery post published successfully.' : '';
            $error = $success ? '' : 'Unable to save the gallery post.';
        }
    }
}

$news_list = get_all_news();
$team_list = get_all_team_members();
$gallery_list = get_all_gallery_items();
$applications = get_all_admission_applications();
$image_options = [
    'banner2.jpeg' => 'Campus Activity',
    'banner3.jpeg' => 'School Event',
    'banner-kfi.jpg' => 'Main Campus',
    'banner-kfi-1.jpg' => 'Students',
    'founder.jpg' => 'Founder',
    'programd.png' => 'Program Director',
    'princapal.jpg' => 'Principal',
    'logo.png' => 'KFI Logo',
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KFI Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-dashboard-page">
    <nav class="admin-topbar">
        <div>
            <span class="admin-kicker">Kingdom Foundation Institute</span>
            <h1>Admin Dashboard</h1>
        </div>
        <div class="admin-topbar-actions">
            <a href="../index.php" class="btn btn-outline-light btn-sm" target="_blank">View Website</a>
            <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
        </div>
    </nav>

    <main class="container py-4 py-lg-5">
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <section class="admin-metrics-grid mb-4">
            <div><strong><?php echo count($news_list); ?></strong><span>News Posts</span></div>
            <div><strong><?php echo count($team_list); ?></strong><span>Team Members</span></div>
            <div><strong><?php echo count($gallery_list); ?></strong><span>Gallery Posts</span></div>
            <div><strong><?php echo count($applications); ?></strong><span>Admission Inquiries</span></div>
        </section>

        <ul class="nav nav-pills admin-tabs mb-4" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#news-panel" type="button">News</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#team-panel" type="button">Team</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#gallery-panel" type="button">Gallery</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#applications-panel" type="button">Admissions</button></li>
        </ul>

        <div class="tab-content">
            <section class="tab-pane fade show active" id="news-panel">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="admin-panel">
                            <h2>Publish News</h2>
                            <form method="post">
                                <label class="form-label" for="title">Headline</label>
                                <input type="text" name="title" id="title" class="form-control mb-3" required>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="category">Category</label>
                                        <select name="category" id="category" class="form-select">
                                            <option>Announcement</option>
                                            <option>School Event</option>
                                            <option>Academic Achievement</option>
                                            <option>Admissions</option>
                                            <option>Community</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="date">Date</label>
                                        <input type="date" name="date" id="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <label class="form-label mt-3" for="image">Image</label>
                                <select name="image" id="image" class="form-select">
                                    <?php foreach ($image_options as $file => $label): ?>
                                        <option value="<?php echo htmlspecialchars($file); ?>"><?php echo htmlspecialchars($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label class="form-label mt-3" for="summary">Summary</label>
                                <textarea name="summary" id="summary" class="form-control" rows="5" required></textarea>
                                <button type="submit" name="post_news" class="btn btn-school w-100 mt-4">Publish News</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="admin-panel">
                            <h2>Published News</h2>
                            <?php if (empty($news_list)): ?>
                                <div class="admin-empty-state">No news has been published yet.</div>
                            <?php else: ?>
                                <div class="admin-news-list">
                                    <?php foreach ($news_list as $item): ?>
                                        <article class="admin-news-row">
                                            <img src="../<?php echo htmlspecialchars(news_image_url($item['image'] ?? '')); ?>" alt="">
                                            <div>
                                                <span><?php echo htmlspecialchars(date('M d, Y', strtotime($item['date'] ?? 'now'))); ?> / <?php echo htmlspecialchars($item['category'] ?? 'Announcement'); ?></span>
                                                <h3><?php echo htmlspecialchars($item['title'] ?? 'Untitled'); ?></h3>
                                                <p><?php echo htmlspecialchars(excerpt_text($item['summary'] ?? '', 105)); ?></p>
                                            </div>
                                            <form method="post">
                                                <input type="hidden" name="news_id" value="<?php echo htmlspecialchars($item['id'] ?? ''); ?>">
                                                <button type="submit" name="delete_news" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this news article?');"><i class="bi bi-trash3"></i></button>
                                            </form>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tab-pane fade" id="team-panel">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="admin-panel">
                            <h2>Add Team Member</h2>
                            <form method="post">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control mb-3" required>
                                <label class="form-label" for="role">Role</label>
                                <input type="text" name="role" id="role" class="form-control mb-3" required>
                                <label class="form-label" for="person_type">People Group</label>
                                <select name="person_type" id="person_type" class="form-select mb-3">
                                    <option>Board Member</option>
                                    <option>Administration</option>
                                    <option>Staff</option>
                                    <option>Lecturer</option>
                                    <option>Teacher</option>
                                </select>
                                <label class="form-label" for="department">Department Badge</label>
                                <input type="text" name="department" id="department" class="form-control mb-3" placeholder="Executive Leadership">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control">
                                    </div>
                                </div>
                                <label class="form-label mt-3" for="team_image">Image</label>
                                <select name="image" id="team_image" class="form-select">
                                    <?php foreach ($image_options as $file => $label): ?>
                                        <option value="<?php echo htmlspecialchars($file); ?>"><?php echo htmlspecialchars($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label class="form-label mt-3" for="sort_order">Display Order</label>
                                <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?php echo count($team_list) + 1; ?>">
                                <label class="form-label mt-3" for="bio">Bio</label>
                                <textarea name="bio" id="bio" class="form-control" rows="5"></textarea>
                                <button type="submit" name="post_team" class="btn btn-school w-100 mt-4">Add Team Member</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="admin-panel">
                            <h2>Team Members</h2>
                            <div class="admin-news-list">
                                <?php foreach ($team_list as $item): ?>
                                    <article class="admin-news-row">
                                        <img src="../<?php echo htmlspecialchars(news_image_url($item['image'] ?? '')); ?>" alt="">
                                        <div>
                                            <span><?php echo htmlspecialchars(($item['person_type'] ?? 'Staff') . ' / ' . ($item['department'] ?? 'Leadership')); ?></span>
                                            <h3><?php echo htmlspecialchars($item['name'] ?? 'Team member'); ?></h3>
                                            <p><?php echo htmlspecialchars($item['role'] ?? ''); ?></p>
                                        </div>
                                        <form method="post">
                                            <input type="hidden" name="team_id" value="<?php echo htmlspecialchars($item['id'] ?? ''); ?>">
                                            <button type="submit" name="delete_team" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this team member?');"><i class="bi bi-trash3"></i></button>
                                        </form>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tab-pane fade" id="gallery-panel">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="admin-panel">
                            <h2>Post Gallery Item</h2>
                            <form method="post">
                                <label class="form-label" for="gallery_title">Title</label>
                                <input type="text" name="gallery_title" id="gallery_title" class="form-control mb-3" required>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="gallery_category">Category</label>
                                        <select name="gallery_category" id="gallery_category" class="form-select">
                                            <option>Campus Life</option>
                                            <option>Events</option>
                                            <option>Academics</option>
                                            <option>Community</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="gallery_date">Date</label>
                                        <input type="date" name="gallery_date" id="gallery_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <label class="form-label mt-3" for="gallery_image">Image</label>
                                <select name="gallery_image" id="gallery_image" class="form-select">
                                    <?php foreach ($image_options as $file => $label): ?>
                                        <option value="<?php echo htmlspecialchars($file); ?>"><?php echo htmlspecialchars($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label class="form-label mt-3" for="caption">Caption</label>
                                <textarea name="caption" id="caption" class="form-control" rows="5"></textarea>
                                <button type="submit" name="post_gallery" class="btn btn-school w-100 mt-4">Post Gallery Item</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="admin-panel">
                            <h2>Gallery Posts</h2>
                            <div class="admin-news-list">
                                <?php foreach ($gallery_list as $item): ?>
                                    <article class="admin-news-row">
                                        <img src="../<?php echo htmlspecialchars(news_image_url($item['image'] ?? '')); ?>" alt="">
                                        <div>
                                            <span><?php echo htmlspecialchars(date('M d, Y', strtotime($item['date'] ?? 'now'))); ?> / <?php echo htmlspecialchars($item['category'] ?? 'Campus Life'); ?></span>
                                            <h3><?php echo htmlspecialchars($item['title'] ?? 'Gallery item'); ?></h3>
                                            <p><?php echo htmlspecialchars(excerpt_text($item['caption'] ?? '', 105)); ?></p>
                                        </div>
                                        <form method="post">
                                            <input type="hidden" name="gallery_id" value="<?php echo htmlspecialchars($item['id'] ?? ''); ?>">
                                            <button type="submit" name="delete_gallery" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this gallery post?');"><i class="bi bi-trash3"></i></button>
                                        </form>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tab-pane fade" id="applications-panel">
                <div class="admin-panel">
                    <h2>Admission Inquiries</h2>
                    <?php if (empty($applications)): ?>
                        <div class="admin-empty-state">No admission inquiries have been submitted yet.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table admin-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Submitted</th>
                                        <th>Student</th>
                                        <th>Grade</th>
                                        <th>Parent</th>
                                        <th>Contact</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($applications as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars(date('M d, Y g:i A', strtotime($item['submitted_at'] ?? 'now'))); ?></td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($item['student_name'] ?? ''); ?></strong><br>
                                                <small><?php echo htmlspecialchars($item['previous_school'] ?? ''); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($item['grade'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($item['parent_name'] ?? ''); ?></td>
                                            <td>
                                                <a href="tel:<?php echo htmlspecialchars($item['phone'] ?? ''); ?>"><?php echo htmlspecialchars($item['phone'] ?? ''); ?></a><br>
                                                <small><?php echo htmlspecialchars($item['email'] ?? ''); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars(excerpt_text($item['message'] ?? '', 120)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
