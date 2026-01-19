# RSD ZT CREATE – Zabbix Template Creator

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D%208.2-blue.svg)](https://www.php.net/)
[![Laravel Framework](https://img.shields.io/badge/framework-Laravel%2011-red.svg)](https://laravel.com)

**RSD ZT CREATE** is an advanced open-source tool designed for the professional generation of Zabbix Templates. Focused on Low Level Discovery (LLD) and complex monitoring scenarios, it streamlines the process of creating high-quality, vendor-ready templates for SOC, NOC, MSP, and Enterprise environments.

---

## 🚀 Features

- **Automatic Template Generation**: Create complex Zabbix templates (v6.x / v7.x) in seconds.
- **Full Low Level Discovery (LLD)**: Deep support for discovery rules, item prototypes, trigger prototypes, and graph prototypes.
- **Web Scenario Builder**: Full implementation of HTTP tests, steps, authentication, and LLD-based scenario prototypes.
- **SNMP Template Generator**: Specialized support for SNMP get, walk, trap, and bulk operations.
- **ExternalScripts & AlertScripts**: Seamless integration for custom collection methods.
- **Pre-processing Engine**: Support for Regex, JSONPath, Javascript, and custom error handling.
- **Tag & Macro Management**: Standardized global and specific tags/macros for professional organization.
- **Vendor-Oriented**: Built-in support for vendor metadata and standardized naming conventions.
- **Zabbix JSON Export**: Generates 100% compatible JSON files ready for direct import.

---

## 🏗️ Architecture

- **Builder Pattern**: Uses a robust builder architecture to separate template logic from the export format.
- **Separation of Concerns**: Decoupled models for Templates, Items, LLD, and Web Scenarios.
- **Zero Zabbix Dependency**: Does not require a running Zabbix Server to generate templates.
- **Modern Stack**: Built with PHP 8.2+ and Laravel 11 for maximum performance and maintainability.

---

## 🛠️ Installation

### Prerequisites

- PHP >= 8.2
- Composer
- SQLite (default) or MySQL

### Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/rsdenck/rsd-ztcreate.git
   cd rsd-ztcreate
   ```

2. Install dependencies:
   ```bash\n   composer install
   ```

3. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Start the local server:
   ```bash
   php artisan serve
   ```

---

## 📖 Usage

### Web Interface
Access the Wizard UI at `http://localhost:8000` to create your template step-by-step:
1. **Metadata**: Define template name, group, and vendor.
2. **Macros & Tags**: Set global variables and organization tags.
3. **Items**: Add regular items (Agent, SNMP, HTTP).
4. **LLD Rules**: Configure discovery rules and prototypes.
5. **Web Scenarios**: Set up complex HTTP monitoring.
6. **Export**: Preview and download the Zabbix-compatible JSON.

### CLI Mode (Planned)
Generate templates directly from the terminal using artisan commands.

---

## 📤 Export & Compatibility

The generated JSON files follow the official Zabbix schema and are compatible with:
- **Zabbix 6.0 LTS / 6.4**
- **Zabbix 7.0 LTS / 7.2**

All exports include validation to ensure a smooth import process into your Zabbix instance.

---

## 🗺️ Roadmap

- [ ] **UI Wizard Enhancement**: Drag-and-drop step reordering.
- [ ] **Template Marketplace**: Community-driven repository for shared templates.
- [ ] **Auto-Validation**: Real-time syntax checking for Zabbix expressions.
- [ ] **Zabbix API Integration**: Direct push to Zabbix Server.
- [ ] **Multi-format Export**: Support for YAML and XML.

---

## 🤝 Contributing

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---

Developed by **rdenck** - [GitHub](https://github.com/rsdenck)