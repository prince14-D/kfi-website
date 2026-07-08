<?php
/**
 * KFI Storage Helper - Handles JSON data persistence.
 */
define('NEWS_STORAGE', __DIR__ . '/../data/news.json');
define('TEAM_STORAGE', __DIR__ . '/../data/team.json');
define('GALLERY_STORAGE', __DIR__ . '/../data/gallery.json');
define('TESTIMONIALS_STORAGE', __DIR__ . '/../data/testimonials.json');
define('ADMISSIONS_STORAGE', __DIR__ . '/../data/admissions.json');
define('DONATIONS_STORAGE', __DIR__ . '/../data/donations.json');
define('CELSIN_STORAGE', __DIR__ . '/../data/celsin_registrations.json');

function ensure_json_storage($path) {
    $directory = dirname($path);

    if (!file_exists($directory)) {
        mkdir($directory, 0775, true);
    }

    if (!file_exists($path)) {
        file_put_contents($path, json_encode([], JSON_PRETTY_PRINT));
    }
}

function read_json_storage($path) {
    ensure_json_storage($path);

    $json = file_get_contents($path);
    $data = json_decode($json, true);

    return is_array($data) ? $data : [];
}

function write_json_storage($path, $data) {
    ensure_json_storage($path);

    return file_put_contents($path, json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX) !== false;
}

function ensure_news_storage() {
    ensure_json_storage(NEWS_STORAGE);
}

function get_all_news() {
    $data = read_json_storage(NEWS_STORAGE);

    usort($data, function($a, $b) {
        return strtotime($b['date'] ?? '') <=> strtotime($a['date'] ?? '');
    });

    return $data;
}

function get_recent_news($limit = 3) {
    return array_slice(get_all_news(), 0, $limit);
}

function save_news_item($item) {
    ensure_news_storage();

    $news = get_all_news();
    $news[] = [
        'id' => $item['id'] ?? uniqid('news_', true),
        'title' => trim($item['title'] ?? ''),
        'date' => $item['date'] ?? date('Y-m-d'),
        'category' => trim($item['category'] ?? 'Announcement'),
        'summary' => trim($item['summary'] ?? ''),
        'image' => normalize_news_image($item['image'] ?? ''),
    ];

    return write_json_storage(NEWS_STORAGE, $news);
}

function delete_news_item($id) {
    ensure_news_storage();

    $news = array_values(array_filter(get_all_news(), function($item) use ($id) {
        return ($item['id'] ?? '') !== $id;
    }));

    return write_json_storage(NEWS_STORAGE, $news);
}

function normalize_asset_image($image, $fallback = 'assets/images/banner2.jpeg') {
    $image = trim($image);

    if ($image === '') {
        return $fallback;
    }

    $image = basename($image);
    return 'assets/images/' . $image;
}

function normalize_news_image($image) {
    return normalize_asset_image($image, 'assets/images/banner2.jpeg');
}

function news_image_url($image) {
    $image = normalize_news_image($image);

    if (!file_exists(__DIR__ . '/../' . $image)) {
        return 'assets/images/banner2.jpeg';
    }

    return $image;
}

function excerpt_text($text, $limit = 160) {
    $text = trim(strip_tags($text));

    if (strlen($text) <= $limit) {
        return $text;
    }

    return rtrim(substr($text, 0, $limit - 3)) . '...';
}

function get_all_team_members() {
    $members = read_json_storage(TEAM_STORAGE);

    usort($members, function($a, $b) {
        return (int)($a['sort_order'] ?? 99) <=> (int)($b['sort_order'] ?? 99);
    });

    return $members;
}

function get_featured_team_members($limit = 4) {
    return array_slice(get_all_team_members(), 0, $limit);
}

function save_team_member($item) {
    $team = get_all_team_members();
    $id = $item['id'] ?? '';
    $record = [
        'id' => $id !== '' ? $id : uniqid('team_', true),
        'name' => trim($item['name'] ?? ''),
        'role' => trim($item['role'] ?? ''),
        'person_type' => trim($item['person_type'] ?? 'Staff'),
        'department' => trim($item['department'] ?? 'Leadership'),
        'bio' => trim($item['bio'] ?? ''),
        'email' => trim($item['email'] ?? ''),
        'phone' => trim($item['phone'] ?? ''),
        'image' => normalize_asset_image($item['image'] ?? '', 'assets/images/logo.png'),
        'sort_order' => (int)($item['sort_order'] ?? 99),
    ];

    $updated = false;
    foreach ($team as $index => $member) {
        if (($member['id'] ?? '') === $record['id']) {
            $team[$index] = $record;
            $updated = true;
            break;
        }
    }

    if (!$updated) {
        $team[] = $record;
    }

    return write_json_storage(TEAM_STORAGE, $team);
}

function delete_team_member($id) {
    $team = array_values(array_filter(get_all_team_members(), function($item) use ($id) {
        return ($item['id'] ?? '') !== $id;
    }));

    return write_json_storage(TEAM_STORAGE, $team);
}

function get_all_gallery_items() {
    $items = read_json_storage(GALLERY_STORAGE);

    usort($items, function($a, $b) {
        return strtotime($b['date'] ?? '') <=> strtotime($a['date'] ?? '');
    });

    return $items;
}

function get_featured_gallery_items($limit = 6) {
    return array_slice(get_all_gallery_items(), 0, $limit);
}

function save_gallery_item($item) {
    $gallery = get_all_gallery_items();
    $gallery[] = [
        'id' => $item['id'] ?? uniqid('gallery_', true),
        'title' => trim($item['title'] ?? ''),
        'category' => trim($item['category'] ?? 'Campus Life'),
        'date' => $item['date'] ?? date('Y-m-d'),
        'caption' => trim($item['caption'] ?? ''),
        'image' => normalize_asset_image($item['image'] ?? '', 'assets/images/banner3.jpeg'),
    ];

    return write_json_storage(GALLERY_STORAGE, $gallery);
}

function delete_gallery_item($id) {
    $gallery = array_values(array_filter(get_all_gallery_items(), function($item) use ($id) {
        return ($item['id'] ?? '') !== $id;
    }));

    return write_json_storage(GALLERY_STORAGE, $gallery);
}

function get_all_testimonials() {
    $testimonials = read_json_storage(TESTIMONIALS_STORAGE);

    usort($testimonials, function($a, $b) {
        return (int)($a['sort_order'] ?? 99) <=> (int)($b['sort_order'] ?? 99);
    });

    return $testimonials;
}

function get_featured_testimonials($limit = 4) {
    return array_slice(get_all_testimonials(), 0, $limit);
}

function save_testimonial($item) {
    $testimonials = get_all_testimonials();
    $id = $item['id'] ?? '';
    $record = [
        'id' => $id !== '' ? $id : uniqid('testimonial_', true),
        'quote' => trim($item['quote'] ?? ''),
        'author' => trim($item['author'] ?? ''),
        'author_title' => trim($item['author_title'] ?? 'Parent'),
        'image' => normalize_asset_image($item['image'] ?? '', 'assets/images/logo.png'),
        'sort_order' => (int)($item['sort_order'] ?? 99),
    ];

    $updated = false;
    foreach ($testimonials as $index => $testimonial) {
        if (($testimonial['id'] ?? '') === $record['id']) {
            $testimonials[$index] = $record;
            $updated = true;
            break;
        }
    }

    if (!$updated) {
        $testimonials[] = $record;
    }

    return write_json_storage(TESTIMONIALS_STORAGE, $testimonials);
}

function delete_testimonial($id) {
    $testimonials = array_values(array_filter(get_all_testimonials(), function($item) use ($id) {
        return ($item['id'] ?? '') !== $id;
    }));

    return write_json_storage(TESTIMONIALS_STORAGE, $testimonials);
}

function save_admission_application($item) {
    $applications = get_all_admission_applications();
    $applications[] = [
        'id' => $item['id'] ?? uniqid('admission_', true),
        'submitted_at' => date('Y-m-d H:i:s'),
        'student_name' => trim($item['student_name'] ?? ''),
        'grade' => trim($item['grade'] ?? ''),
        'dob' => trim($item['dob'] ?? ''),
        'parent_name' => trim($item['parent_name'] ?? ''),
        'phone' => trim($item['phone'] ?? ''),
        'email' => trim($item['email'] ?? ''),
        'previous_school' => trim($item['previous_school'] ?? ''),
        'message' => trim($item['message'] ?? ''),
    ];

    return write_json_storage(ADMISSIONS_STORAGE, $applications);
}

function get_all_admission_applications() {
    $applications = read_json_storage(ADMISSIONS_STORAGE);

    usort($applications, function($a, $b) {
        return strtotime($b['submitted_at'] ?? '') <=> strtotime($a['submitted_at'] ?? '');
    });

    return $applications;
}

function save_donation($item) {
    $donations = get_all_donations();
    $donations[] = [
        'id' => $item['id'] ?? uniqid('donation_', true),
        'submitted_at' => date('Y-m-d H:i:s'),
        'donor_name' => trim($item['donorName'] ?? ''),
        'donor_email' => trim($item['donorEmail'] ?? ''),
        'donor_phone' => trim($item['donorPhone'] ?? ''),
        'amount' => trim($item['donationAmount'] ?? ''),
        'fund' => trim($item['donationFund'] ?? ''),
        'message' => trim($item['donorMessage'] ?? ''),
        'status' => 'pending',
    ];

    return write_json_storage(DONATIONS_STORAGE, $donations);
}

function get_all_donations() {
    $donations = read_json_storage(DONATIONS_STORAGE);

    usort($donations, function($a, $b) {
        return strtotime($b['submitted_at'] ?? '') <=> strtotime($a['submitted_at'] ?? '');
    });

    return $donations;
}

function delete_donation($id) {
    $donations = array_values(array_filter(get_all_donations(), function($item) use ($id) {
        return ($item['id'] ?? '') !== $id;
    }));

    return write_json_storage(DONATIONS_STORAGE, $donations);
}

// CEDSIN Registration Functions
function ensure_celsin_storage() {
    ensure_json_storage(CELSIN_STORAGE);
}

function get_all_celsin_registrations() {
    ensure_celsin_storage();
    return read_json_storage(CELSIN_STORAGE);
}

function save_celsin_registration($item) {
    ensure_celsin_storage();
    
    $registrations = get_all_celsin_registrations();
    $registrations[] = [
        'id' => $item['id'] ?? uniqid('celsin_', true),
        'school_name' => trim($item['school_name'] ?? ''),
        'contact_name' => trim($item['contact_name'] ?? ''),
        'contact_email' => trim($item['contact_email'] ?? ''),
        'contact_phone' => trim($item['contact_phone'] ?? ''),
        'service_interest' => trim($item['service_interest'] ?? ''),
        'school_size' => trim($item['school_size'] ?? ''),
        'message' => trim($item['message'] ?? ''),
        'submitted_at' => date('Y-m-d H:i:s'),
    ];

    return write_json_storage(CELSIN_STORAGE, $registrations);
}

function delete_celsin_registration($id) {
    $registrations = array_values(array_filter(get_all_celsin_registrations(), function($item) use ($id) {
        return ($item['id'] ?? '') !== $id;
    }));

    return write_json_storage(CELSIN_STORAGE, $registrations);
}
