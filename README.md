Here’s a **README.md** for your PHP Instagram Graph API uploader project.

---

````markdown
# 📷 PHP Instagram Graph API – Image Uploader

This project is a **PHP script** that uploads an image to Instagram using the **Instagram Graph API** through a connected **Facebook Page** and **Instagram Business Account**.  
It supports **caption**, **hashtags**, and **optional location tagging**.

---

## 🚀 Features
- Authenticate using your **Facebook Graph API access token**.
- Fetch **Facebook Page ID** by name.
- Get the **Instagram Business Account ID** connected to the Page.
- Upload an image with:
  - Custom caption
  - Hashtags
  - Optional location tag
- Publish the post to Instagram automatically.
- Basic error handling with API response checks.

---

## 🛠 Requirements
- PHP 7.4+ (or PHP 8+ recommended)
- A **Facebook App** with `instagram_basic`, `pages_show_list`, `instagram_content_publish` permissions.
- A **Facebook Page** linked to an **Instagram Business Account**.
- A **valid long-lived access token**.

---

## 📦 Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/ShahnawazKakarh/instagram-upload-image-api
   cd php-instagram-uploader
````

2. **Install dependencies**

   * This script uses a custom `CallAPI.php` function to handle HTTP requests.
   * Ensure you have it in `../automated-articles/library/functions/CallAPI.php` or update the path.

3. **Configure credentials**
   Open the script and update:

   ```php
   $access_token_use_own = "YOUR_LONG_LIVED_ACCESS_TOKEN";
   $page_id_use_own = "YOUR_FACEBOOK_PAGE_ID";
   $fb_page_name = "Your Facebook Page Name";
   ```

4. **Get a long-lived access token**
   Follow Facebook’s documentation:

   * [https://developers.facebook.com/docs/facebook-login/access-tokens/refreshing](https://developers.facebook.com/docs/facebook-login/access-tokens/refreshing)

---

## ▶ Usage

Run the script in CLI:

```bash
php upload_to_instagram.php
```

Or place it on a server and run via browser.

---

### Example Configuration in Script:

```php
$image_url = "https://example.com/image.jpg";
$caption = "#HelloWorld This is my first API post!";
$location_id = "1234567890"; // Optional: Facebook location ID
```

---

## 📌 How It Works

1. **Get Facebook Page ID**
   Calls `/me/accounts` to find the Page by name.

2. **Get Instagram Business Account ID**
   Calls `/{page_id}?fields=instagram_business_account`.

3. **Create Media Container**
   Calls `/{ig_user_id}/media` with image URL, caption, and optional location.

4. **Publish Media**
   Calls `/{ig_user_id}/media_publish` with the container ID.

---

## 📜 API Endpoints Used

* **Get Pages:**
  `GET https://graph.facebook.com/v14.0/me/accounts`
* **Get IG Business Account ID:**
  `GET https://graph.facebook.com/v14.0/{page_id}?fields=instagram_business_account`
* **Create Media Container:**
  `POST https://graph.facebook.com/v14.0/{ig_user_id}/media`
* **Publish Media:**
  `POST https://graph.facebook.com/v14.0/{ig_user_id}/media_publish`

---

## ⚠️ Notes

* Instagram Graph API only supports posting **images and videos** from a Business/Creator account.
* **Image must be publicly accessible** via a direct URL.
* Captions must be **max 2,200 characters** and hashtags **max 30 per post**.

---

## 📄 License

This project is for **educational purposes only**.
You are responsible for complying with Facebook & Instagram API terms when using it.
