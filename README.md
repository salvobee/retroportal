# 🕰️ RetroPortal

> **Bringing the modern web to vintage browsers**

**RetroPortal** is your gateway to today's internet from yesterday's technology. Experience modern websites, search the web, read news, and check the weather—all from your favorite retro browser, whether it's running on Windows 95, Mac OS 9, or even a text-based terminal.

[![Made with Laravel](https://img.shields.io/badge/Made%20with-Laravel-red.svg)](https://laravel.com)
[![PHP 8.2+](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

---

## 🎯 What is RetroPortal?

RetroPortal bridges the gap between vintage computing and the modern web. It's a server-side application that fetches contemporary web content and transforms it into **HTML 3.2-compatible** markup that works flawlessly on browsers from the 1990s and early 2000s.

Perfect for:
- **Retro computing enthusiasts** running vintage systems
- **Text-based browser users** (Lynx, w3m, links)
- **Low-bandwidth environments** requiring minimal data usage
- **Accessibility needs** with simplified, clean markup
- **Nostalgia seekers** wanting to experience the web as it once was

---

## ✨ Core Features

### 🌐 **Universal Web Proxy**
Transform any modern HTTPS website into retro-friendly HTML. Our intelligent proxy:
- Strips JavaScript, CSS, and modern elements that break old browsers
- Converts HTTPS sites to HTTP for legacy compatibility
- Uses readability algorithms to extract clean, readable content
- Automatically detects and serves AMP versions when available
- Rewrites all links and images to work through the proxy

### 🔍 **Web Search**
Search the entire web using DuckDuckGo's API with results optimized for vintage browsers:
- Clean, text-based search results
- Localized results in multiple languages
- All result links automatically proxified for seamless browsing
- Fast, lightweight interface that loads instantly on any connection

### 📰 **News Headlines**
Stay informed with current news from around the world:
- Real-time headlines from Google News RSS feeds
- Localized news based on your language preference
- Clean, readable format perfect for text-based browsers
- Cached for optimal performance on slow connections

### 🌤️ **Weather Service**
Check current weather conditions for any city worldwide:
- Real-time weather data from OpenWeatherMap
- Temperature, humidity, pressure, and wind information
- Simple, table-based layout for maximum compatibility
- Works with or without API configuration (demo mode available)

### 📚 **Encyclopedia (Wikipedia)**
Access the world's knowledge from your vintage browser:
- Search Wikipedia articles with clean, readable summaries
- Automatic content extraction optimized for retro displays
- Multi-language Wikipedia support matching your interface language
- Fast, cached responses perfect for slow connections
- Academic-quality information in a format that works on any browser

### 🤖 **ChatbotAI (LLM Integration)**
Bring modern AI assistance to vintage computing:
- Chat with advanced language models from browsers that predate the internet
- Support for multiple LLM providers (OpenAI, Anthropic, local models)
- Conversation history maintained across sessions
- Responses formatted for maximum readability on text-based displays
- Perfect for research, learning, and problem-solving on retro systems

### 🌍 **Multi-Language Support**
Navigate in your preferred language:
- Currently supports English and Italian
- Easy language switching with persistent preferences
- Localized content and interface elements
- Session and cookie-based preference storage

### 🎨 **Retro Theming**
Choose your visual experience:
- **Light Theme**: Classic early web aesthetics
- **Dark Theme**: Easy on the eyes for extended browsing
- Uses legacy HTML color attributes for maximum browser compatibility
- Instant theme switching with persistent preferences

---

## 🚀 Quick Start

**Prerequisites**: RetroPortal requires a modern server with PHP 8.2+ and composer 2+ to run. This server will act as a bridge between your vintage browser and the modern web. **The server can be any computer on your network** (Windows, Mac, Linux) with PHP installed.

Get RetroPortal running in minutes:

```bash
# Clone the repository
git clone https://github.com/salvobee/retroportal.git
cd retroportal

# Install dependencies
composer install

# Set up environment
cp .env.example .env
php artisan key:generate

# Start the server
php artisan serve
```

Visit `http://your_server_host:8000` in any browser—from Internet Explorer 1.0 to the latest Chrome!

**Network Setup**: Replace `your_server_host` with the actual IP address or hostname of the computer running RetroPortal. For example:
- Same computer: `http://localhost:8000`
- Local network: `http://192.168.1.100:8000`
- Custom hostname: `http://retroserver.local:8000`

### ⚙️ Optional Configurations

**Weather Service** - For real weather data, get a free API key from [OpenWeatherMap](https://openweathermap.org/api):
```bash
OPENWEATHERMAP_API_KEY=your_api_key_here
```

**ChatbotAI** - Configure your LLM API key (only OpenAI supported so far):
```bash
OPENAI_KEY==your_openai_key_here
```


---

## 🎮 Perfect For

- **Vintage Computer Collections**: Browse modern sites on your oldest computers using all kind of browsers
- **Retro Gaming Setups**: Check news, weather, and chat with AI between gaming sessions
- **Educational Projects**: Research topics on Wikipedia and get AI assistance on vintage hardware
- **Academic Research**: Access encyclopedic knowledge and AI-powered insights from any era of computing
- **Low-Resource Environments**: Minimal bandwidth and processing requirements
- **Accessibility Research**: Study simplified web interfaces and their benefits
- **Digital Archaeology**: Experience the web as it was meant to be—simple and fast
- **Vintage AI Experiments**: Explore modern AI capabilities on computers from the pre-internet era

---

## 🛠️ Technical Highlights

- **Laravel 12** backend for robust, modern server-side processing
- **HTML 3.2 compliance** ensuring compatibility with browsers from 1995+
- **Zero JavaScript** requirement—everything works with JS disabled
- **Table-based layouts** for consistent rendering across all browsers
- **Intelligent content extraction** using readability algorithms
- **Comprehensive caching** for optimal performance on slow connections

---

## 🗺️ Feature Status

- ✅ **Universal Web Proxy** - Browse modern HTTPS sites from vintage browsers
- ✅ **Web Search** - DuckDuckGo integration with proxified results
- ✅ **News Headlines** - Real-time news from RSS
- ✅ **Weather Service** - Current conditions from OpenWeatherMap
- ✅ **Encyclopedia** - Wikipedia search and article summaries
- ✅ **ChatbotAI** - LLM integration for vintage computing
- ✅ **Multi-Language Support** - English and Italian interfaces
- ✅ **Retro Theming** - Light and dark themes with legacy compatibility
- 🔄 **Image Optimization** - JPEG/GIF fallback for maximum compatibility
- 🔄 **Extended Languages** - Additional interface languages

---

## 🤝 Contributing

RetroPortal is open source and welcomes contributions! Whether you're fixing bugs, adding features, or improving documentation, your help makes the retro web better for everyone.

---

## 📜 License

RetroPortal is free and open source software licensed under the [MIT License](LICENSE).

---

**Experience the web as it was meant to be—simple, fast, and accessible to everyone.** 🌐✨
