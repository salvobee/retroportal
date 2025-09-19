Here’s a **draft `README.md`** for your retro-friendly Laravel project, written fully in English:

---

# Legacy Portal

**Legacy Portal** is a Laravel 12 application that provides access to modern web services through a **retro-compatible interface**.
The goal is to make the modern web accessible from **obsolete or text-based browsers** (e.g., Classilla on Mac OS9, Internet Explorer 1.0 on Windows 95, Lynx, etc.).

It uses **server-side integrations** (APIs) to fetch modern content and renders it as **minimal HTML 3.2 markup** with inline attributes, ensuring compatibility with very old browsers.

---

## ✨ Features (in progress)

* **Language selector** (multi-language interface with Laravel Localization)
* **Theme selector** (light/dark themes implemented with legacy `<body>` attributes)
* **Search** via DuckDuckGo Instant Answer API (localized by session language)
* **News** (planned, via RSS aggregator or API like Google News)
* **Weather** (planned, via OpenWeather or similar)
* **Wikipedia** (planned, via Wikipedia API, text-only summaries)
* Future integrations:

    * Social Media feeds (Facebook, Instagram, X/Twitter)
    * YouTube (public videos, trending lists)
    * Spotify (charts, playback info)
    * Podcasts & Web Radio (MP3/PLS links usable on old players)

---

## 🏗 Project structure

* **`resources/views/layout/app.blade.php`**
  Main layout, legacy-friendly (HTML 3.2 + inline attributes + minimal CSS).

* **`resources/lang/{locale}/ui.php`**
  Translation files for menu labels, theme toggle, etc.

* **`app/Http/Middleware/SetLocale.php`**
  Reads current language from session and applies it to the application.

* **`app/Services/Search/`**
  Service layer for search engines. Current implementation: DuckDuckGo.

* **`app/Http/Controllers/RetroPortalController.php`**
  Page controllers for Search, News, Weather, Wikipedia.

---

## 🔌 Requirements

* PHP 8.2+
* Laravel 12.30.1
* Composer
* A writable `storage/` directory (sessions & cache)

---

## 🚀 Installation

1. Clone this repository:

   ```bash
   git clone https://github.com/salvobee/legacy-portal.git
   cd legacy-portal
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Create `.env`:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure session driver (default `file` is fine):

   ```env
   SESSION_DRIVER=file
   ```

5. Run the development server:

   ```bash
   php artisan serve
   ```

6. Open `http://localhost:8000` in your retro browser (or a modern one for testing).

---

## 🌍 Multi-language support

* Current supported locales: **English (en)**, **Italian (it)**
* Language is stored in session and applied via middleware.
* To switch language:

    * Click the links in the layout header (`English | Italiano`)
    * Or visit `/lang/en` or `/lang/it`

---

## 🎨 Theming

* Two themes available: **Light** and **Dark**
* Implemented using legacy `<body bgcolor>` and link color attributes
* Switch via header link (stored in session)

---

## 🔎 Search integration

* Current implementation: **DuckDuckGo Instant Answer API**
* Localized by session language (`kl` + `hl` params)
* Returns:

    * Abstract (from Wikipedia or other sources)
    * Related topics (links + text)

Limitations:

* Some abstracts only available in English if the requested language has no entry.
* Future improvement: automatic translation fallback.

---

## 🛠 Roadmap

* [x] Multilingual UI (Laravel Localization)
* [x] Theme selector (light/dark)
* [x] DuckDuckGo search integration
* [ ] News aggregation (RSS, Google News API alternative)
* [ ] Weather integration (OpenWeather API)
* [ ] Wikipedia summaries (via MediaWiki API)
* [ ] Translation fallback for abstracts (Google Translate API or DeepL)
* [ ] OAuth integrations (Spotify, YouTube, Social Media)

---

## 📜 License

This project is open-source. License to be defined (MIT recommended).

---

Do you want me to also include a **retro screenshot mockup** (ASCII style preview of the UI) in the README so it visually shows how the site looks in an old browser?
