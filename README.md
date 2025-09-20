# RetroPortal

**RetroPortal** is a Laravel 12 application that brings the **modern web** to **retro and text-based browsers** (Mac OS9 Classilla, Windows 95 Internet Explorer 1.0, Lynx, etc.).

It fetches modern content **server-side** and re-renders it in **HTML 3.2** with minimal attributes, ensuring maximum compatibility.

---

## ✨ Features

* 🌐 **Reader Proxy**

    * Browse modern HTTPS websites from legacy HTTP-only browsers.
    * Fetches pages server-side, strips JavaScript & CSS, rewrites links and images through the proxy.
    * Detects AMP pages or uses a “reader mode” (Readability) for simplified content.
    * Always shows a minimal header with “Open Original” + navigation.

* 🔎 **Web Search**

    * DuckDuckGo Instant Answer API.
    * Localized results (`kl`, `hl` params based on session language).
    * Links automatically proxified through the Reader Proxy.

* 📰 **News**

    * Google News RSS feeds (localized by language).
    * Returns clean headlines with proxified links.
    * Caching for efficiency and retro responsiveness.

* 🌍 **Multi-language UI**

    * Current: English (`en`), Italian (`it`).
    * Language preference stored in session and cookie.

* 🎨 **Theming**

    * Light/Dark themes.
    * Implemented with legacy `<body>` color attributes for full backward compatibility.
    * Theme preference stored in session and cookie.

---

## 🏗 Project Structure

### Controllers

Organized by **namespace**:

* `App\Http\Controllers\Settings\ThemeController`
* `App\Http\Controllers\Settings\LanguageController`
* `App\Http\Controllers\Features\WebSearchController`
* `App\Http\Controllers\Features\NewsController`
* `App\Http\Controllers\Features\ProxyController`
* `App\Http\Controllers\Features\ImageProxyController`
* `App\Http\Controllers\Features\WeatherController` *(planned)*
* `App\Http\Controllers\Features\WikipediaController` *(planned)*

### Services

* `App\Services\Search\DuckDuckGoWebSearch`
* `App\Services\News\GoogleNewsRssService`
* `App\Services\Proxy\ReaderProxyService`

### Support

* `App\Support\UrlProxy` → helper for proxifying links and images.

### Middleware

* `App\Http\Middleware\SetLocale` → applies session/cookie locale to app.

### Views

* `resources/views/layout/app.blade.php` → minimal global layout.
* `resources/views/pages/*.blade.php` → feature pages (home, search, news, proxy, etc.).

### Localization

* `resources/lang/en/ui.php`
* `resources/lang/it/ui.php`

---

## 🔌 Requirements

* PHP 8.2+
* Laravel 12.30.1
* Composer
* `file` session driver recommended for retro setups
* `mbstring` extension for encoding normalization

---

## 🚀 Installation

```bash
git clone https://github.com/yourname/retroportal.git
cd retroportal
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Open `http://localhost:8000` in your retro browser (or a modern one for testing).

---

## 🌍 Multi-language

* Default: English (`en`)
* Italian (`it`) available
* Switch via `/lang/en` or `/lang/it` (or header links).
* Language preference stored in **session + cookie**.

---

## 🎨 Theming

* Two modes: **Light** and **Dark**.
* Switch via `/theme/light` or `/theme/dark`.
* Preference stored in **session + cookie**.

---

## 📰 News

* Fetched from **Google News RSS**.
* Localized by `app()->getLocale()`:

    * `it` → `hl=it&gl=IT&ceid=IT:it`
    * `en` → `hl=en&gl=US&ceid=US:en`
    * etc.
* Cached for 5 minutes.

---

## 🔎 Search

* Implemented with **DuckDuckGo Instant Answer API**.
* Localized with `hl` and `kl` parameters.
* Results simplified and proxified through Reader Proxy.

---

## 🌐 Reader Proxy (Main Feature)

* Entry point: `/proxy?url=https://example.com`
* Fetches HTTPS content server-side → serves via HTTP.
* Simplifies markup:

    * Removes scripts, CSS, iframes.
    * Detects AMP pages when available.
    * Uses **Readability** if installed (`fivefilters/readability.php`).
* Rewrites:

    * `<a href>` → `/proxy?url=...`
    * `<img src>` → `/proxy/image?url=...`
* Image proxy (`/proxy/image`) serves HTTPS images as HTTP.
* Minimal header with:

    * Current site name.
    * “Open original” link.
    * Link back to Home.

---

## 🛠 Roadmap

* [x] Multi-language support (session + cookie).
* [x] Theme selector (session + cookie).
* [x] DuckDuckGo search integration.
* [x] Google News RSS integration.
* [x] Reader Proxy (core feature).
* [ ] Wikipedia summaries (via MediaWiki API).
* [ ] Weather integration (OpenWeather).
* [ ] Domain allowlist / HMAC protection for proxy.
* [ ] Optional down-conversion of images (JPEG/GIF fallback).
* [ ] Translation fallback for abstracts/news.

---

## 📜 License

This project is **Free and Open Source**. License: **MIT** (recommended).
