# RSD ZT CREATE – Advanced Zabbix Template Creator

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D%208.2-blue.svg)](https://www.php.net/)
[![Laravel Framework](https://img.shields.io/badge/framework-Laravel%2011-red.svg)](https://laravel.com)

**RSD ZT CREATE** is an advanced open-source tool designed for the professional generation of Zabbix Templates. Focused on Low Level Discovery (LLD), API automation, and complex monitoring scenarios, it streamlines the process of creating high-quality, vendor-ready templates for SOC, NOC, MSP, and Enterprise environments.

---

## 📚 Documentation

For detailed information about project requirements and features, please refer to:
- [Requirements Coverage](docs/requirements.md) - Check what has been implemented.
- [Features & Usage Guide](docs/features.md) - Detailed guide on how to use the application.
- [Technical Architecture](docs/architecture.md) - Deep dive into the system design.

---

## 🚀 Key Features

- **Intelligent Trigger Creator**: Build advanced triggers (Standard, Recovery, Prototype) with a smart UI assistant, validation engine, and support for complex Zabbix functions.
- **API Template Generator**: Automatically generate complete templates (LLD, Items, Triggers) from REST, SOAP, or GraphQL endpoints.
- **Full Low Level Discovery (LLD)**: Deep support for discovery rules, item prototypes, trigger prototypes, and graph prototypes.
- **Web Scenario Builder**: Full implementation of HTTP tests, steps, authentication, and LLD-based scenario prototypes.
- **Automatic Template Generation**: Create complex Zabbix templates (v6.x / v7.x) in seconds via a guided Wizard.
- **Pre-processing Engine**: Support for Regex, JSONPath, XPath, Javascript, and custom error handling.
- **Tag & Macro Management**: Standardized global and specific tags/macros for professional organization.
- **Vendor-Oriented**: Built-in support for vendor metadata and standardized naming conventions.
- **Zabbix JSON Export**: Generates 100% compatible JSON files ready for direct import.

---

## 🏗️ Architecture

- **Builder Pattern**: Uses a robust builder architecture to separate template logic from the export format.
- **API Analyzer Layer**: Specialized services for detecting API structures and generating LLD rules automatically.
- **Trigger Rule Engine**: Validates and constructs complex Zabbix expressions without manual coding.
- **Modern Stack**: Built with PHP 8.2+ and Laravel 11 for maximum performance and maintainability.

---

## 🛠️ Installation

### Prerequisites

- PHP >= 8.2
- Composer
- SQLite (default) or MySQL

### Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/rsdenck/rsd-ztcreate.git
   cd rsd-ztcreate
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

5. **Start the local server:**
   ```bash
   php artisan serve
   ```

---

## 📖 Usage

### Web Interface
Access the Wizard UI at `http://localhost:8000` to create your template step-by-step:
1. **Metadata**: Define template name, group, and vendor.
2. **Creation Mode**: Choose between Manual or API-based generation.
3. **Macros & Tags**: Set global variables and organization tags.
4. **Items & LLD**: Add regular items or configure discovery rules.
5. **Trigger Creator**: Use the intelligent assistant to build alerts.
6. **Web Scenarios**: Set up complex HTTP monitoring.
7. **Export**: Preview and download the Zabbix-compatible JSON.

---

## 📤 Export & Compatibility

The generated JSON files follow the official Zabbix schema and are compatible with:
- **Zabbix 6.0 LTS / 6.4**
- **Zabbix 7.0 LTS / 7.2**

---

## 🗺️ Roadmap

- [x] **API Template Generation** (REST/SOAP/GraphQL)
- [x] **Intelligent Trigger Creator**
- [ ] **Grafana Dashboard Exporter**
- [ ] **Bulk API Discovery**
- [ ] **CLI Mode** for CI/CD integration

---

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.
