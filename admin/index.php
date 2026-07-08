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

function handle_admin_image_upload($field, $prefix) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return '';
    }

    $uploadDir = __DIR__ . '/../assets/images/';
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $fileType = $_FILES[$field]['type'];

    if (!in_array($fileType, $allowedTypes)) {
        return '';
    }

    $extension = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
    $newFileName = $prefix . '_' . uniqid() . '.' . $extension;
    $targetPath = $uploadDir . $newFileName;

    if (move_uploaded_file($_FILES[$field]['tmp_name'], $targetPath)) {
        return 'assets/images/' . $newFileName;
    }

    return '';
}

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

    if (isset($_POST['delete_testimonial'])) {
        $success = delete_testimonial($_POST['testimonial_id'] ?? '') ? 'Testimonial deleted.' : '';
        $error = $success ? '' : 'Unable to delete the testimonial.';
    }

    if (isset($_POST['post_news'])) {
        $title = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');

        if ($title === '' || $summary === '') {
            $error = 'Please add a news headline and summary before publishing.';
        } else {
            // Handle image upload
            $imagePath = $_POST['image'] ?? '';
            if (isset($_FILES['news_upload_image']) && $_FILES['news_upload_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../assets/images/';
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $fileType = $_FILES['news_upload_image']['type'];
                
                if (in_array($fileType, $allowedTypes)) {
                    $extension = pathinfo($_FILES['news_upload_image']['name'], PATHINFO_EXTENSION);
                    $newFileName = 'news_' . uniqid() . '.' . $extension;
                    $targetPath = $uploadDir . $newFileName;
                    
                    if (move_uploaded_file($_FILES['news_upload_image']['tmp_name'], $targetPath)) {
                        $imagePath = 'assets/images/' . $newFileName;
                    }
                }
            }
            
            $success = save_news_item([
                'title' => $title,
                'date' => $_POST['date'] ?: date('Y-m-d'),
                'category' => $_POST['category'] ?? 'Announcement',
                'summary' => $summary,
                'image' => $imagePath,
            ]) ? 'News article published successfully.' : '';
            $error = $success ? '' : 'Unable to save the news article.';
        }
    }

    if (isset($_POST['post_team']) || isset($_POST['update_team'])) {
        $name = trim($_POST['name'] ?? '');
        $role = trim($_POST['role'] ?? '');

        if ($name === '' || $role === '') {
            $error = 'Please add the team member name and role.';
        } else {
            // Handle image upload
            $imagePath = $_POST['image'] ?? '';
            if (isset($_FILES['team_upload_image']) && $_FILES['team_upload_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../assets/images/';
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $fileType = $_FILES['team_upload_image']['type'];
                
                if (in_array($fileType, $allowedTypes)) {
                    $extension = pathinfo($_FILES['team_upload_image']['name'], PATHINFO_EXTENSION);
                    $newFileName = 'team_' . uniqid() . '.' . $extension;
                    $targetPath = $uploadDir . $newFileName;
                    
                    if (move_uploaded_file($_FILES['team_upload_image']['tmp_name'], $targetPath)) {
                        $imagePath = 'assets/images/' . $newFileName;
                    }
                }
            }

            if ($imagePath === '') {
                $imagePath = $_POST['existing_team_image'] ?? '';
            }
            
            $teamData = $_POST;
            $teamData['image'] = $imagePath;
            $success = save_team_member($teamData) ? (isset($_POST['update_team']) ? 'Team member updated successfully.' : 'Team member added successfully.') : '';
            $error = $success ? '' : 'Unable to save the team member.';
        }
    }

    if (isset($_POST['post_gallery'])) {
        $title = trim($_POST['gallery_title'] ?? '');

        if ($title === '') {
            $error = 'Please add a gallery title.';
        } else {
            // Handle image upload
            $imagePath = $_POST['gallery_image'] ?? '';
            if (isset($_FILES['gallery_upload_image']) && $_FILES['gallery_upload_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../assets/images/';
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $fileType = $_FILES['gallery_upload_image']['type'];
                
                if (in_array($fileType, $allowedTypes)) {
                    $extension = pathinfo($_FILES['gallery_upload_image']['name'], PATHINFO_EXTENSION);
                    $newFileName = 'gallery_' . uniqid() . '.' . $extension;
                    $targetPath = $uploadDir . $newFileName;
                    
                    if (move_uploaded_file($_FILES['gallery_upload_image']['tmp_name'], $targetPath)) {
                        $imagePath = 'assets/images/' . $newFileName;
                    }
                }
            }
            
            $success = save_gallery_item([
                'title' => $title,
                'category' => $_POST['gallery_category'] ?? 'Campus Life',
                'date' => $_POST['gallery_date'] ?: date('Y-m-d'),
                'caption' => $_POST['caption'] ?? '',
                'image' => $imagePath,
            ]) ? 'Gallery post published successfully.' : '';
            $error = $success ? '' : 'Unable to save the gallery post.';
        }
    }

    if (isset($_POST['post_testimonial']) || isset($_POST['update_testimonial'])) {
        $quote = trim($_POST['testimonial_quote'] ?? '');
        $author = trim($_POST['testimonial_author'] ?? '');

        if ($quote === '' || $author === '') {
            $error = 'Please add the testimonial quote and author.';
        } else {
            $imagePath = $_POST['testimonial_image'] ?? '';
            $uploadedImage = handle_admin_image_upload('testimonial_upload_image', 'testimonial');

            if ($uploadedImage !== '') {
                $imagePath = $uploadedImage;
            } elseif ($imagePath === '') {
                $imagePath = $_POST['existing_testimonial_image'] ?? '';
            }

            $success = save_testimonial([
                'id' => $_POST['testimonial_id'] ?? '',
                'quote' => $quote,
                'author' => $author,
                'author_title' => $_POST['testimonial_author_title'] ?? 'Parent',
                'image' => $imagePath,
                'sort_order' => $_POST['testimonial_sort_order'] ?? 99,
            ]) ? (isset($_POST['update_testimonial']) ? 'Testimonial updated successfully.' : 'Testimonial published successfully.') : '';
            $error = $success ? '' : 'Unable to save the testimonial.';
        }
    }

    // Handle CEDSIN Registration Form Submission
    if (isset($_POST['submit_celsin_registration'])) {
        $school_name = trim($_POST['school_name'] ?? '');
        $contact_name = trim($_POST['contact_name'] ?? '');
        $contact_email = trim($_POST['contact_email'] ?? '');
        $contact_phone = trim($_POST['contact_phone'] ?? '');
        $service_interest = trim($_POST['service_interest'] ?? '');
        $school_size = trim($_POST['school_size'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($school_name === '' || $contact_name === '' || $contact_email === '') {
            $error = 'Please fill in all required fields.';
        } else {
            $success = save_celsin_registration([
                'school_name' => $school_name,
                'contact_name' => $contact_name,
                'contact_email' => $contact_email,
                'contact_phone' => $contact_phone,
                'service_interest' => $service_interest,
                'school_size' => $school_size,
                'message' => $message,
            ]);
            
            if ($success) {
                header('Location: ../academic.php?success=1');
                exit;
            } else {
                $error = 'Unable to save the registration.';
            }
        }
    }

    if (isset($_POST['delete_donation'])) {
        $success = delete_donation($_POST['donation_id'] ?? '') ? 'Donation request deleted.' : '';
        $error = $success ? '' : 'Unable to delete the donation request.';
    }

    if (isset($_POST['delete_celsin'])) {
        $success = delete_celsin_registration($_POST['celsin_id'] ?? '') ? 'CEDSIN - KFI registration deleted.' : '';
        $error = $success ? '' : 'Unable to delete the CEDSIN - KFI registration.';
    }
}

if (isset($_GET['export_donations'])) {
    $donations = get_all_donations();
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="kfi_donations_' . date('Y-m-d') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Submitted', 'Name', 'Email', 'Phone', 'Amount', 'Fund', 'Message']);
    foreach ($donations as $item) {
        fputcsv($output, [
            $item['submitted_at'] ?? '',
            $item['donor_name'] ?? '',
            $item['donor_email'] ?? '',
            $item['donor_phone'] ?? '',
            $item['amount'] ?? '',
            $item['fund'] ?? '',
            $item['message'] ?? '',
        ]);
    }
    fclose($output);
    exit;
}

if (isset($_GET['export_celsin'])) {
    $cedsin = get_all_celsin_registrations();
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="celsin_registrations_' . date('Y-m-d') . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Submitted', 'School Name', 'Contact Name', 'Email', 'Phone', 'Service Interest', 'School Size', 'Message']);
    foreach ($cedsin as $item) {
        fputcsv($output, [
            $item['submitted_at'] ?? '',
            $item['school_name'] ?? '',
            $item['contact_name'] ?? '',
            $item['contact_email'] ?? '',
            $item['contact_phone'] ?? '',
            $item['service_interest'] ?? '',
            $item['school_size'] ?? '',
            $item['message'] ?? '',
        ]);
    }
    fclose($output);
    exit;
}

$news_list = get_all_news();
$team_list = get_all_team_members();
$gallery_list = get_all_gallery_items();
$testimonial_list = get_all_testimonials();
$applications = get_all_admission_applications();
$donations = get_all_donations();
            $celsin_registrations = get_all_celsin_registrations();
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
            <div><strong><?php echo count($testimonial_list); ?></strong><span>Testimonials</span></div>
            <div><strong><?php echo count($applications); ?></strong><span>Admission Inquiries</span></div>
            <div><strong><?php echo count($donations); ?></strong><span>Donation Requests</span></div>
            <div><strong><?php echo count($celsin_registrations); ?></strong><span>CEDSIN - KFI Registrations</span></div>
        </section>

        <ul class="nav nav-pills admin-tabs mb-4" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#news-panel" type="button">News</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#team-panel" type="button">Team</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#gallery-panel" type="button">Gallery</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#testimonials-panel" type="button">Testimonials</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#applications-panel" type="button">Admissions</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#donations-panel" type="button">Donations</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#celsin-panel" type="button">CEDSIN - KFI Registrations</button></li>
        </ul>

        <div class="tab-content">
            <section class="tab-pane fade show active" id="news-panel">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="admin-panel">
                            <h2>Publish News</h2>
                            <form method="post" enctype="multipart/form-data">
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
                                <select name="image" id="image" class="form-select mb-2">
                                    <?php foreach ($image_options as $file => $label): ?>
                                        <option value="<?php echo htmlspecialchars($file); ?>"><?php echo htmlspecialchars($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text mb-2">Or upload a new image:</div>
                                <input type="file" name="news_upload_image" id="news_upload_image" class="form-control mb-3" accept="image/*">
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
                            <form method="post" enctype="multipart/form-data">
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
                                <div class="input-group mb-2">
                                    <select name="image" id="team_image" class="form-select">
                                        <option value="">-- Select existing image --</option>
                                        <?php foreach ($image_options as $file => $label): ?>
                                            <option value="<?php echo htmlspecialchars($file); ?>"><?php echo htmlspecialchars($label); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-text mb-2">Or upload a new image:</div>
                                <input type="file" name="team_upload_image" id="team_upload_image" class="form-control mb-3" accept="image/*">
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
                                    <?php $team_modal_id = 'teamEdit' . preg_replace('/[^A-Za-z0-9_-]/', '', $item['id'] ?? ''); ?>
                                    <article class="admin-news-row">
                                        <img src="../<?php echo htmlspecialchars(news_image_url($item['image'] ?? '')); ?>" alt="">
                                        <div>
                                            <span><?php echo htmlspecialchars(($item['person_type'] ?? 'Staff') . ' / ' . ($item['department'] ?? 'Leadership')); ?></span>
                                            <h3><?php echo htmlspecialchars($item['name'] ?? 'Team member'); ?></h3>
                                            <p><?php echo htmlspecialchars($item['role'] ?? ''); ?></p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#<?php echo htmlspecialchars($team_modal_id); ?>"><i class="bi bi-pencil-square"></i></button>
                                            <form method="post">
                                                <input type="hidden" name="team_id" value="<?php echo htmlspecialchars($item['id'] ?? ''); ?>">
                                                <button type="submit" name="delete_team" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this team member?');"><i class="bi bi-trash3"></i></button>
                                            </form>
                                        </div>
                                    </article>

                                    <div class="modal fade" id="<?php echo htmlspecialchars($team_modal_id); ?>" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Team Member</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id'] ?? ''); ?>">
                                                        <input type="hidden" name="existing_team_image" value="<?php echo htmlspecialchars($item['image'] ?? ''); ?>">

                                                        <label class="form-label" for="<?php echo htmlspecialchars($team_modal_id); ?>Name">Name</label>
                                                        <input type="text" name="name" id="<?php echo htmlspecialchars($team_modal_id); ?>Name" class="form-control mb-3" value="<?php echo htmlspecialchars($item['name'] ?? ''); ?>" required>

                                                        <label class="form-label" for="<?php echo htmlspecialchars($team_modal_id); ?>Role">Role</label>
                                                        <input type="text" name="role" id="<?php echo htmlspecialchars($team_modal_id); ?>Role" class="form-control mb-3" value="<?php echo htmlspecialchars($item['role'] ?? ''); ?>" required>

                                                        <label class="form-label" for="<?php echo htmlspecialchars($team_modal_id); ?>Type">People Group</label>
                                                        <select name="person_type" id="<?php echo htmlspecialchars($team_modal_id); ?>Type" class="form-select mb-3">
                                                            <option <?php echo ($item['person_type'] ?? '') === 'Board Member' ? 'selected' : ''; ?>>Board Member</option>
                                                            <option <?php echo ($item['person_type'] ?? '') === 'Administration' ? 'selected' : ''; ?>>Administration</option>
                                                            <option <?php echo ($item['person_type'] ?? '') === 'Staff' ? 'selected' : ''; ?>>Staff</option>
                                                            <option <?php echo ($item['person_type'] ?? '') === 'Lecturer' ? 'selected' : ''; ?>>Lecturer</option>
                                                            <option <?php echo ($item['person_type'] ?? '') === 'Teacher' ? 'selected' : ''; ?>>Teacher</option>
                                                        </select>

                                                        <label class="form-label" for="<?php echo htmlspecialchars($team_modal_id); ?>Department">Department Badge</label>
                                                        <input type="text" name="department" id="<?php echo htmlspecialchars($team_modal_id); ?>Department" class="form-control mb-3" value="<?php echo htmlspecialchars($item['department'] ?? ''); ?>">

                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="<?php echo htmlspecialchars($team_modal_id); ?>Email">Email</label>
                                                                <input type="email" name="email" id="<?php echo htmlspecialchars($team_modal_id); ?>Email" class="form-control" value="<?php echo htmlspecialchars($item['email'] ?? ''); ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="<?php echo htmlspecialchars($team_modal_id); ?>Phone">Phone</label>
                                                                <input type="text" name="phone" id="<?php echo htmlspecialchars($team_modal_id); ?>Phone" class="form-control" value="<?php echo htmlspecialchars($item['phone'] ?? ''); ?>">
                                                            </div>
                                                        </div>

                                                        <label class="form-label mt-3" for="<?php echo htmlspecialchars($team_modal_id); ?>Image">Image</label>
                                                        <select name="image" id="<?php echo htmlspecialchars($team_modal_id); ?>Image" class="form-select mb-2">
                                                            <option value="">Keep current image</option>
                                                            <?php foreach ($image_options as $file => $label): ?>
                                                                <option value="<?php echo htmlspecialchars($file); ?>" <?php echo basename($item['image'] ?? '') === $file ? 'selected' : ''; ?>><?php echo htmlspecialchars($label); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>

                                                        <div class="form-text mb-2">Or upload a new image:</div>
                                                        <input type="file" name="team_upload_image" class="form-control mb-3" accept="image/*">

                                                        <label class="form-label" for="<?php echo htmlspecialchars($team_modal_id); ?>SortOrder">Display Order</label>
                                                        <input type="number" name="sort_order" id="<?php echo htmlspecialchars($team_modal_id); ?>SortOrder" class="form-control mb-3" value="<?php echo htmlspecialchars($item['sort_order'] ?? 99); ?>">

                                                        <label class="form-label" for="<?php echo htmlspecialchars($team_modal_id); ?>Bio">Bio</label>
                                                        <textarea name="bio" id="<?php echo htmlspecialchars($team_modal_id); ?>Bio" class="form-control" rows="5"><?php echo htmlspecialchars($item['bio'] ?? ''); ?></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="update_team" class="btn btn-school">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
                            <form method="post" enctype="multipart/form-data">
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
                                <select name="gallery_image" id="gallery_image" class="form-select mb-2">
                                    <?php foreach ($image_options as $file => $label): ?>
                                        <option value="<?php echo htmlspecialchars($file); ?>"><?php echo htmlspecialchars($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text mb-2">Or upload a new image:</div>
                                <input type="file" name="gallery_upload_image" id="gallery_upload_image" class="form-control mb-3" accept="image/*">
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

            <section class="tab-pane fade" id="testimonials-panel">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="admin-panel">
                            <h2>Publish Testimonial</h2>
                            <form method="post" enctype="multipart/form-data">
                                <label class="form-label" for="testimonial_quote">Quote</label>
                                <textarea name="testimonial_quote" id="testimonial_quote" class="form-control mb-3" rows="5" required></textarea>
                                <label class="form-label" for="testimonial_author">Author</label>
                                <input type="text" name="testimonial_author" id="testimonial_author" class="form-control mb-3" required>
                                <label class="form-label" for="testimonial_author_title">Author Detail</label>
                                <input type="text" name="testimonial_author_title" id="testimonial_author_title" class="form-control mb-3" value="Parent">
                                <label class="form-label" for="testimonial_image">Image</label>
                                <select name="testimonial_image" id="testimonial_image" class="form-select mb-2">
                                    <?php foreach ($image_options as $file => $label): ?>
                                        <option value="<?php echo htmlspecialchars($file); ?>"><?php echo htmlspecialchars($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text mb-2">Or upload a new image:</div>
                                <input type="file" name="testimonial_upload_image" id="testimonial_upload_image" class="form-control mb-3" accept="image/*">
                                <label class="form-label" for="testimonial_sort_order">Display Order</label>
                                <input type="number" name="testimonial_sort_order" id="testimonial_sort_order" class="form-control" value="<?php echo count($testimonial_list) + 1; ?>">
                                <button type="submit" name="post_testimonial" class="btn btn-school w-100 mt-4">Publish Testimonial</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="admin-panel">
                            <h2>Testimonials</h2>
                            <?php if (empty($testimonial_list)): ?>
                                <div class="admin-empty-state">No testimonials have been published yet.</div>
                            <?php else: ?>
                                <div class="admin-news-list">
                                    <?php foreach ($testimonial_list as $item): ?>
                                        <?php $testimonial_modal_id = 'testimonialEdit' . preg_replace('/[^A-Za-z0-9_-]/', '', $item['id'] ?? ''); ?>
                                        <article class="admin-news-row">
                                            <img src="../<?php echo htmlspecialchars(news_image_url($item['image'] ?? '')); ?>" alt="">
                                            <div>
                                                <span>Order <?php echo htmlspecialchars($item['sort_order'] ?? ''); ?> / <?php echo htmlspecialchars($item['author_title'] ?? 'Parent'); ?></span>
                                                <h3><?php echo htmlspecialchars($item['author'] ?? 'Community member'); ?></h3>
                                                <p><?php echo htmlspecialchars(excerpt_text($item['quote'] ?? '', 120)); ?></p>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#<?php echo htmlspecialchars($testimonial_modal_id); ?>"><i class="bi bi-pencil-square"></i></button>
                                                <form method="post">
                                                    <input type="hidden" name="testimonial_id" value="<?php echo htmlspecialchars($item['id'] ?? ''); ?>">
                                                    <button type="submit" name="delete_testimonial" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this testimonial?');"><i class="bi bi-trash3"></i></button>
                                                </form>
                                            </div>
                                        </article>

                                        <div class="modal fade" id="<?php echo htmlspecialchars($testimonial_modal_id); ?>" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Testimonial</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="testimonial_id" value="<?php echo htmlspecialchars($item['id'] ?? ''); ?>">
                                                            <input type="hidden" name="existing_testimonial_image" value="<?php echo htmlspecialchars($item['image'] ?? ''); ?>">
                                                            <label class="form-label" for="<?php echo htmlspecialchars($testimonial_modal_id); ?>Quote">Quote</label>
                                                            <textarea name="testimonial_quote" id="<?php echo htmlspecialchars($testimonial_modal_id); ?>Quote" class="form-control mb-3" rows="5" required><?php echo htmlspecialchars($item['quote'] ?? ''); ?></textarea>
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label" for="<?php echo htmlspecialchars($testimonial_modal_id); ?>Author">Author</label>
                                                                    <input type="text" name="testimonial_author" id="<?php echo htmlspecialchars($testimonial_modal_id); ?>Author" class="form-control" value="<?php echo htmlspecialchars($item['author'] ?? ''); ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label" for="<?php echo htmlspecialchars($testimonial_modal_id); ?>Title">Author Detail</label>
                                                                    <input type="text" name="testimonial_author_title" id="<?php echo htmlspecialchars($testimonial_modal_id); ?>Title" class="form-control" value="<?php echo htmlspecialchars($item['author_title'] ?? 'Parent'); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 mt-1">
                                                                <div class="col-md-8">
                                                                    <label class="form-label" for="<?php echo htmlspecialchars($testimonial_modal_id); ?>Image">Image</label>
                                                                    <select name="testimonial_image" id="<?php echo htmlspecialchars($testimonial_modal_id); ?>Image" class="form-select">
                                                                        <option value="">Keep current image</option>
                                                                        <?php foreach ($image_options as $file => $label): ?>
                                                                            <option value="<?php echo htmlspecialchars($file); ?>" <?php echo basename($item['image'] ?? '') === $file ? 'selected' : ''; ?>><?php echo htmlspecialchars($label); ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label" for="<?php echo htmlspecialchars($testimonial_modal_id); ?>Order">Display Order</label>
                                                                    <input type="number" name="testimonial_sort_order" id="<?php echo htmlspecialchars($testimonial_modal_id); ?>Order" class="form-control" value="<?php echo htmlspecialchars($item['sort_order'] ?? 99); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-text mt-3 mb-2">Or upload a new image:</div>
                                                            <input type="file" name="testimonial_upload_image" class="form-control" accept="image/*">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" name="update_testimonial" class="btn btn-school">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
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

            <section class="tab-pane fade" id="donations-panel">
                <div class="admin-panel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">Donation Requests</h2>
                        <?php if (!empty($donations)): ?>
                            <a href="?export_donations=1" class="btn btn-success btn-sm"><i class="bi bi-download me-1"></i> Export CSV</a>
                        <?php endif; ?>
                    </div>
                    <?php if (empty($donations)): ?>
                        <div class="admin-empty-state">No donation requests have been submitted yet.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table admin-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Submitted</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($donations as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars(date('M d, Y g:i A', strtotime($item['submitted_at'] ?? 'now'))); ?></td>
                                            <td><strong><?php echo htmlspecialchars($item['donor_name'] ?? ''); ?></strong></td>
                                            <td><a href="mailto:<?php echo htmlspecialchars($item['donor_email'] ?? ''); ?>"><?php echo htmlspecialchars($item['donor_email'] ?? ''); ?></a></td>
                                            <td><a href="tel:<?php echo htmlspecialchars($item['donor_phone'] ?? ''); ?>"><?php echo htmlspecialchars($item['donor_phone'] ?? ''); ?></a></td>
                                            <td><?php echo htmlspecialchars($item['amount'] ?? ''); ?></td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#donationModal<?php echo htmlspecialchars($item['id'] ?? ''); ?>" onclick="var m=new bootstrap.Modal(document.getElementById('donationModal<?php echo htmlspecialchars($item['id'] ?? ''); ?>'));m.show()"><i class="bi bi-eye"></i></button>
                                                    <form method="post">
                                                        <input type="hidden" name="donation_id" value="<?php echo htmlspecialchars($item['id'] ?? ''); ?>">
                                                        <button type="submit" name="delete_donation" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this donation request?');"><i class="bi bi-trash3"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <?php foreach ($donations as $item): ?>
                <div class="modal fade" id="donationModal<?php echo htmlspecialchars($item['id'] ?? ''); ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Donation Request Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Name:</strong></p>
                                        <p class="text-muted"><?php echo htmlspecialchars($item['donor_name'] ?? ''); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Email:</strong></p>
                                        <p class="text-muted"><a href="mailto:<?php echo htmlspecialchars($item['donor_email'] ?? ''); ?>"><?php echo htmlspecialchars($item['donor_email'] ?? ''); ?></a></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Phone:</strong></p>
                                        <p class="text-muted"><a href="tel:<?php echo htmlspecialchars($item['donor_phone'] ?? ''); ?>"><?php echo htmlspecialchars($item['donor_phone'] ?? ''); ?></a></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Amount:</strong></p>
                                        <p class="text-muted"><?php echo htmlspecialchars($item['amount'] ?? ''); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Fund:</strong></p>
                                        <p class="text-muted"><?php echo htmlspecialchars($item['fund'] ?? ''); ?></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="mb-2"><strong>Submitted:</strong></p>
                                        <p class="text-muted"><?php echo htmlspecialchars(date('F d, Y g:i A', strtotime($item['submitted_at'] ?? 'now'))); ?></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="mb-2"><strong>Message:</strong></p>
                                        <p class="text-muted"><?php echo nl2br(htmlspecialchars($item['message'] ?? 'No message provided.')); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="mailto:<?php echo htmlspecialchars($item['donor_email'] ?? ''); ?>?subject=Re: KFI Donation Inquiry" class="btn btn-primary"><i class="bi bi-envelope me-1"></i> Reply via Email</a>
                                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $item['donor_phone'] ?? ''); ?>" target="_blank" class="btn btn-success"><i class="bi bi-whatsapp me-1"></i> Contact via WhatsApp</a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>

            <section class="tab-pane fade" id="celsin-panel">
                <div class="admin-panel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>CEDSIN - KFI Registrations</h2>
                        <?php if (!empty($celsin_registrations)): ?>
                            <a href="?export_celsin" class="btn btn-success"><i class="bi bi-download me-1"></i> Export CSV</a>
                        <?php endif; ?>
                    </div>
                    <?php if (empty($celsin_registrations)): ?>
                        <div class="admin-empty-state">No CEDSIN - KFI registrations have been submitted yet.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table admin-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Submitted</th>
                                        <th>School</th>
                                        <th>Contact</th>
                                        <th>Interest</th>
                                        <th>Size</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($celsin_registrations as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars(date('M d, Y g:i A', strtotime($item['submitted_at'] ?? 'now'))); ?></td>
                                            <td><strong><?php echo htmlspecialchars($item['school_name'] ?? ''); ?></strong></td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($item['contact_name'] ?? ''); ?></strong><br>
                                                <small><a href="mailto:<?php echo htmlspecialchars($item['contact_email'] ?? ''); ?>"><?php echo htmlspecialchars($item['contact_email'] ?? ''); ?></a></small><br>
                                                <small><a href="tel:<?php echo htmlspecialchars($item['contact_phone'] ?? ''); ?>"><?php echo htmlspecialchars($item['contact_phone'] ?? ''); ?></a></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($item['service_interest'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($item['school_size'] ?? ''); ?></td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#celsinModal<?php echo htmlspecialchars($item['id'] ?? ''); ?>" onclick="var m=new bootstrap.Modal(document.getElementById('celsinModal<?php echo htmlspecialchars($item['id'] ?? ''); ?>'));m.show()"><i class="bi bi-eye"></i></button>
                                                    <form method="post">
                                                        <input type="hidden" name="celsin_id" value="<?php echo htmlspecialchars($item['id'] ?? ''); ?>">
                                                        <button type="submit" name="delete_celsin" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this registration?');"><i class="bi bi-trash3"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <?php foreach ($celsin_registrations as $item): ?>
                <div class="modal fade" id="celsinModal<?php echo htmlspecialchars($item['id'] ?? ''); ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo htmlspecialchars($item['school_name'] ?? ''); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Contact Person:</strong></p>
                                        <p class="text-muted"><?php echo htmlspecialchars($item['contact_name'] ?? ''); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Email:</strong></p>
                                        <p class="text-muted"><a href="mailto:<?php echo htmlspecialchars($item['contact_email'] ?? ''); ?>"><?php echo htmlspecialchars($item['contact_email'] ?? ''); ?></a></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Phone:</strong></p>
                                        <p class="text-muted"><a href="tel:<?php echo htmlspecialchars($item['contact_phone'] ?? ''); ?>"><?php echo htmlspecialchars($item['contact_phone'] ?? ''); ?></a></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Service Interest:</strong></p>
                                        <p class="text-muted"><?php echo htmlspecialchars($item['service_interest'] ?? ''); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>School Size:</strong></p>
                                        <p class="text-muted"><?php echo htmlspecialchars($item['school_size'] ?? ''); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Submitted:</strong></p>
                                        <p class="text-muted"><?php echo htmlspecialchars(date('F d, Y g:i A', strtotime($item['submitted_at'] ?? 'now'))); ?></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="mb-2"><strong>Message:</strong></p>
                                        <p class="text-muted"><?php echo nl2br(htmlspecialchars($item['message'] ?? 'No message provided.')); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex gap-2 me-auto">
                                    <a href="tel:<?php echo htmlspecialchars($item['contact_phone'] ?? ''); ?>" class="btn btn-primary"><i class="bi bi-telephone me-1"></i> Call</a>
                                    <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $item['contact_phone'] ?? ''); ?>" target="_blank" class="btn btn-success"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
                                    <a href="mailto:<?php echo htmlspecialchars($item['contact_email'] ?? ''); ?>?subject=Re: CEDSIN - KFI Registration" class="btn btn-outline-primary"><i class="bi bi-envelope me-1"></i> Email</a>
                                </div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize all modals after Bootstrap is loaded
        window.addEventListener('load', function() {
            // Initialize donation modals
            var donationModals = document.querySelectorAll('[id^="donationModal"]');
            donationModals.forEach(function(modalEl) {
                if (typeof bootstrap !== 'undefined' && !modalEl._bsModal) {
                    new bootstrap.Modal(modalEl);
                }
            });
            // Initialize CEDSIN modals
            var celsinModals = document.querySelectorAll('[id^="celsinModal"]');
            celsinModals.forEach(function(modalEl) {
                if (typeof bootstrap !== 'undefined' && !modalEl._bsModal) {
                    new bootstrap.Modal(modalEl);
                }
            });
        });
    </script>
</body>
</html>
