<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kingdom Foundation Institute</title>
  <meta name="theme-color" content="#00008E">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo.png">
  <link rel="shortcut icon" href="assets/images/logo.png">
</head>
<body>
<?php if ($currentPage === 'index.php'): ?>
<div id="splash-screen" aria-hidden="true">
  <img src="assets/images/logo.png" alt="Kingdom Foundation Institute logo">
  <h3>Kingdom Foundation Institute</h3>
  <p class="splash-tagline">CULTURE OF EXCELLENCE</p>
</div>
<?php endif; ?>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top site-navbar">
  <div class="container-fluid px-3 px-lg-4">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <img src="assets/images/logo.png" width="48" height="48" alt="KFI logo">
      <span class="d-flex flex-column lh-sm">
        <span class="fw-bold">Kingdom Foundation Institute</span>
        <small class="brand-tagline text-uppercase d-none d-md-inline">Culture of Excellence</small>
      </span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse navbar-menu-container" id="mainMenu">
      <ul class="navbar-nav ms-auto gap-2 gap-lg-1">
        <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'about.php' ? 'active' : ''; ?>" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'founder.php' ? 'active' : ''; ?>" href="founder.php">Founder</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'academic.php' ? 'active' : ''; ?>" href="academic.php">Academics</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'admissions.php' ? 'active' : ''; ?>" href="admissions.php">Admissions</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'news.php' ? 'active' : ''; ?>" href="news.php">News</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $currentPage === 'contacts.php' ? 'active' : ''; ?>" href="contacts.php">Contact</a></li>
        <li class="nav-item">
          <a href="#" class="btn btn-warning fw-bold px-3 ms-lg-3">E-Portal</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<main class="site-main">
