<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }
require_once '../includes/storage_helper.php';

if (isset($_POST['post_news'])) {
    $new_post = [
        'title' => $_POST['title'],
        'date' => date('F d, Y'),
        'category' => $_POST['category'],
        'summary' => $_POST['summary'],
        'image' => $_POST['image'] ?: 'assets/images/banner2.jpeg'
    ];
    save_news_item($new_post);
    $success = "News article posted successfully!";
}

$news_list = get_all_news();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - KFI Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand fw-bold">KFI Admin Dashboard</span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="row g-4">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3">Post New Article</h5>
                    <?php if(isset($success)): ?> <div class="alert alert-success small"><?php echo $success; ?></div> <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label small">Headline</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Category</label>
                            <select name="category" class="form-select">
                                <option>School Event</option>
                                <option>Academic Achievement</option>
                                <option>Announcement</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Image Name (e.g., banner3.jpeg)</label>
                            <input type="text" name="image" class="form-control" placeholder="banner3.jpeg">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Summary</label>
                            <textarea name="summary" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" name="post_news" class="btn btn-primary w-100 fw-bold">Publish Post</button>
                    </form>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3">Recent Posts</h5>
                    <div class="list-group list-group-flush">
                        <?php foreach($news_list as $item): ?>
                            <div class="list-group-item px-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($item['title']); ?></h6>
                                    <small class="text-muted"><?php echo $item['date']; ?></small>
                                </div>
                                <p class="small text-muted mb-0 mt-1"><?php echo htmlspecialchars($item['category']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>