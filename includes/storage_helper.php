<?php
/**
 * KFI Storage Helper - Handles JSON data persistence
 */
define('NEWS_STORAGE', __DIR__ . '/../data/news.json');

function get_all_news() {
    if (!file_exists(dirname(NEWS_STORAGE))) {
        mkdir(dirname(NEWS_STORAGE), 0777, true);
    }
    
    if (!file_exists(NEWS_STORAGE)) {
        return [];
    }
    
    $json = file_get_contents(NEWS_STORAGE);
    $data = json_decode($json, true);
    
    // Sort by date descending
    usort($data, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
    
    return $data ?: [];
}

function save_news_item($item) {
    $news = get_all_news();
    array_unshift($news, $item);
    file_put_contents(NEWS_STORAGE, json_encode($news, JSON_PRETTY_PRINT));
}