<?php
session_start();
require_once "../automated-articles/library/functions/CallAPI.php";

/**
 * ===========================
 *  CONFIGURATION
 * ===========================
 */
$access_token_use_own = "EAAo4ZC0ZBHudoBAJZAAEGgpwJtusj7HLBvAoVpi1E9fFqCEQmKZANvaVxuByleZBLE3vUvtf2GBzVJBaujn4maP8GPMkoi2ZCLMtqyMdlE4moqto1XJhJ19wjZB2XjEZBZBZBF3NdcKQIVdI7tKUUvTG3Cs2iJZAx7ZC6zZBmxJ9UZAIZA63WYBIPo5ZApK8";
$page_id_use_own = "YOUR_FACEBOOK_PAGE_ID"; // e.g., 1234567890
$fb_page_name     = "Shahnawaz"; // The FB Page Name

// For API calls
$access_token = $access_token_use_own;

/**
 * ===========================
 *  FUNCTIONS
 * ===========================
 */

// Get Facebook Page ID by page name
function get_user_pages($page_name, $access_token) {
    $response = CallAPI("GET", "https://graph.facebook.com/v14.0/me/accounts?access_token={$access_token}");
    if (!isset($response['data'])) {
        die("Error fetching pages: " . json_encode($response));
    }
    foreach ($response['data'] as $page) {
        if ($page['name'] === $page_name) {
            return $page['id'];
        }
    }
    return false;
}

// Get Instagram Business Account ID connected to the FB Page
function get_instagram_user_id($page_id, $access_token) {
    $response = CallAPI("GET", "https://graph.facebook.com/v14.0/{$page_id}?fields=instagram_business_account&access_token={$access_token}");
    if (isset($response['instagram_business_account']['id'])) {
        return $response['instagram_business_account']['id'];
    }
    return false;
}

/**
 * ===========================
 *  MAIN PROCESS
 * ===========================
 */

// 1️⃣ Get the Facebook Page ID
$page_id = get_user_pages($fb_page_name, $access_token);
if (!$page_id) {
    die("Error: Could not find Facebook Page '{$fb_page_name}'.");
}

// 2️⃣ Get the Instagram Business Account ID
$instagram_user_id = get_instagram_user_id($page_id, $access_token);
if (!$instagram_user_id) {
    die("Error: Instagram Business Account not found for Page '{$fb_page_name}'.");
}

// 3️⃣ Media details
$image_url = urlencode("https://nixby.in/wp-content/uploads/igtest.jpg");
$caption   = urlencode("#HelloTest This is a test post with location.");
$location_id = ""; // Optional: Facebook location ID

// 4️⃣ Create a media container
$container_url = "https://graph.facebook.com/v14.0/{$instagram_user_id}/media"
               . "?image_url={$image_url}"
               . "&caption={$caption}"
               . "&access_token={$access_token}";

// If you have a location, add it
if (!empty($location_id)) {
    $container_url .= "&location_id={$location_id}";
}

$get_ig_container_id = CallAPI("POST", $container_url);

if (!isset($get_ig_container_id['id'])) {
    die("Error: Failed to create IG media container: " . json_encode($get_ig_container_id));
}

$_SESSION['creation_id'] = $get_ig_container_id['id'];

// 5️⃣ Publish uploaded media
$publish_url = "https://graph.facebook.com/v14.0/{$instagram_user_id}/media_publish"
             . "?creation_id={$_SESSION['creation_id']}"
             . "&access_token={$access_token}";

$publish_response = CallAPI("POST", $publish_url);

if (!isset($publish_response['id'])) {
    die("Error: Failed to publish media: " . json_encode($publish_response));
}

echo "✅ Media published successfully. Post ID: " . $publish_response['id'];
