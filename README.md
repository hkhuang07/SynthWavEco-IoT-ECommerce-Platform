<p align="center">
  <img src="synwaveco-ecommerce/public/images/synwaveco-logo.jpg" alt="SynWaveEco Logo" height="75"/>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <img src="synwaveco-ecommerce/public/images/logoname.jpg" alt="SynWaveEco Logo Name" height="75"/>
</p>

# 🌊💚 SynWaveEco - Smart E-Commerce & IoT Device Management Platform

> **Beyond Connectivity: Elevating Smart-Life Experiences with Integrity.**

---

## 📌 Table of Contents
- [💡 Project Overview & Problem Solved](#-project-overview--problem-solved)
- [🏢 Business Model](#-business-model)
- [✨ Key Features](#-key-features)
- [🖥️ User Interface & Workflow (Demo Images)](#️-user-interface--workflow-demo-images)
- [🛠️ Technology Stack](#️-technology-stack)
- [🗃️ Database Schema](#️-database-schema)
- [📁 Project Directory Structure](#-project-directory-structure)
- [⚙️ Setup & Installation Guide](#️-setup--installation-guide)
- [🔑 Sample Login Credentials](#-sample-login-credentials)
- [🚀 Strategic Initiatives & Real-World Impact](#-strategic-initiatives--real-world-impact)
- [🎓 Author & Developer](#-author--developer)

---

## 💡 Project Overview & Problem Solved

### 1. Context & Real-World Challenges
In the era of national digital transformation (Vietnam 4.0), the demand for integrating smart technology into precision agriculture (Smart Farming), home automation (Smart Home), and security monitoring for small-and-medium enterprises (SMEs) is growing exponentially. However, customers and developers face significant hurdles:
*   **Component Fragmentation:** Buyers struggle to find pre-integrated, ready-to-deploy IoT packages (Solution Kits), often having to source isolated components from multiple retailers.
*   **Lack of Detailed Technical Documentation:** Generic e-commerce marketplaces fail to provide comprehensive hardware details (e.g., CPU, RAM, protocols, power specifications) needed by developers.
*   **Post-Sale Management Gap:** Most e-commerce stores only handle the transaction. Once purchased, users have no centralized dashboard to register, configure, and monitor their physical IoT devices.

### 2. The SynWaveEco Solution
**SynWaveEco** bridges these gaps by offering a dual-logic E-commerce and Post-Sale IoT Device Management platform built on PHP Laravel 12.
*   **Specialized E-Commerce:** A dedicated hub for electronic components, microcontrollers (Arduino, ESP32, STM32), and custom-tailored IoT kits. Commercial data is cleanly separated from detailed hardware specifications to elevate the shopping experience for developers and technical buyers.
*   **Exclusive Post-Sale IoT Management Module:** An admin/user-facing module where buyers register their physical devices, configure measurement metrics (`device_metrics`), and set safety thresholds (`alert_thresholds` - min/max values) to simulate or monitor real-world device telemetries.
*   **Knowledge Hub:** A curated repository of articles, hardware wiring guides, real-world case studies, and support forums that connect end-users with developers.

---

## 🏢 Business Model

*The business model of SynWaveEco complements and defines the platform's core functional flows:*

### 1. Multi-Channel Distribution Strategy
SynWaveEco operates under a **B2C (Business-to-Consumer)** model, leveraging a multi-channel presence to optimize reach and user support:
*   🌐 **Website & Support:** [Facebook Fanpage](https://www.facebook.com/official.synwaveco/) (Official communication portal)
*   🏪 **Shopee Store:** [shopee.vn/synwaveco](https://shopee.vn/synwaveco) (Official distribution channel)
*   📱 **Social Media Presence:** [TikTok @synwaveco](https://www.tiktok.com/@synwaveco) & [Facebook SynWaveEco](https://www.facebook.com/official.synwaveco/) (For viral 60-second hardware demos and community updates)
*   📺 **YouTube Channel:** [YouTube @synwaveco](https://www.youtube.com/@synwaveco) (Detailed, long-form technical tutorials and embedded systems education)

### 2. Target Customer Segments
*   👨‍👩‍👧‍👦 **Urban Tech Enthusiasts:** Young families looking for affordable, modular smart home setups.
*   👨‍🌾 **Smart Farmers:** Agricultural entrepreneurs seeking precision farming tools (soil moisture, temperature, auto-irrigation kits).
*   🏢 **SOHO (Small Office / Home Office):** Small business owners needing temperature monitors for warehouses or intelligent security setups.

---

## ✨ Key Features

| Icon | Feature | Technical Details |
| :---: | --- | --- |
| 🛒 | **Comprehensive E-Commerce Flow** | Supports complete user flows: catalog browsing, scope-based smart search, advanced filtering (by category/manufacturer), real-time cart updating (Ajax Off-canvas), and secure checkout. |
| 🛡️ | **Multi-level Role Authorization** | Handled securely by `RoleMiddleware` protecting routes for 4 distinct roles: **Admin** (System Control), **Saler** (Inventory & Order Approvals), **Shipper** (Logistics), and **Customer** (Browsing & Device Monitoring). |
| 📊 | **Post-Sale IoT Device Management** | Admin dashboards to register IoT nodes (`iot_devices`), define physical sensor metrics (`device_metrics`), and establish custom threshold values (`alert_thresholds`). |
| 📑 | **Separated Commercial & Technical Data** | Standardized database normalization separating basic retail details (`products`) from intensive hardware specifications (`product_details`: CPU, RAM, power, communication interfaces). |
| 📧 | **Automated Email Notifications** | Automated queue system sending itemized order invoices to customer emails immediately upon successful purchase (`PlaceOrderSuccessEmail.php`). |
| 🔄 | **Bulk Excel/CSV Import & Export** | Integrated `Maatwebsite/Laravel-Excel` library allowing Admins/Salers to bulk update inventory or export reports in seconds. |
| 📚 | **Integrated Knowledge Hub** | Article publishing system categorizing technical documentation by topic (`topics`) and type (`article_types`), linked directly to relevant product pages. |

---

## 🖥️ User Interface & Workflow (Demo Images)

*A comprehensive catalog of actual system screenshots displaying client workflows and management dashboards.*

### 1. Customer-Facing Interface (Client UI)

#### 🌟 Homepage & Banner Promos
<p align="center">
  <img src="demo/home01.jpg" alt="SynWaveEco Homepage" width="900"/>
  <br/>
  <em>Official Homepage displaying responsive design, navigation, and banners</em>
</p>

<p align="center">
  <img src="demo/home02.jpg" alt="Homepage Categories" width="900"/>
  <br/>
  <em>Introduction of product categories and featured smart solutions</em>
</p>

<details>
  <summary>🔍 View More Homepage & Auxiliary Pages</summary>

  <p align="center">
    <img src="demo/home03.jpg" alt="Smart Farming Solutions Section" width="900"/>
    <br/>
    <em>Showcasing Smart Farming solution kits and telemetry dashboard intros</em>
  </p>

  <p align="center">
    <img src="demo/home04.jpg" alt="Footer & Partners" width="900"/>
    <br/>
    <em>Footer section outlining brands, site maps, and partnerships</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-contact.jpg" alt="Contact Page" width="900"/>
    <br/>
    <em>Contact page for technical support and corporate inquiries</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-recruitment.jpg" alt="Recruitment Page" width="900"/>
    <br/>
    <em>Recruitment portal for developers and marketers joining SynWaveEco</em>
  </p>
</details>

#### 📦 Product Catalog & Filters
<p align="center">
  <img src="demo/synwaveco-product-01.jpg" alt="Products Catalog" width="900"/>
  <br/>
  <em>Product grid interface displaying pricing, ratings, and instant cart options</em>
</p>

<details>
  <summary>🔍 View More Product Pages & Filter Operations</summary>

  <p align="center">
    <img src="demo/product-details.jpg" alt="Technical Specifications Sheet" width="900"/>
    <br/>
    <em>Product detail page showing segregated hardware specifications (CPU, RAM, Connections)</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-ecommerce-product-02.jpg" alt="Product Showcase 2" width="900"/>
    <br/>
    <em>Alternative product interface with full description tabs</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-product-03.jpg" alt="Product Reviews" width="900"/>
    <br/>
    <em>Community feedback, hardware tips, and Q&A section under products</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-products-filter-by-category.jpg" alt="Filter by Category" width="900"/>
    <br/>
    <em>Sidebar filtering focusing search results on specific IoT categories (Sensors, Boards)</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-products-filter-by-manufacture.jpg" alt="Filter by Manufacturer" width="900"/>
    <br/>
    <em>Filtering by hardware manufacturer brands (Arduino, Espressif, Raspberry Pi)</em>
  </p>
</details>

---

### 2. Cart, Checkout & User Profile Workflows

#### 💳 Shopping Cart & Checkout
<p align="center">
  <img src="demo/shoppingcard.jpg" alt="Shopping Cart" width="900"/>
  <img src="demo/synwaveco-shoppingcard.jpg" alt="Cart Page" width="900"/>
  <br/>
  <em>Shopping Cart interfaces</em>
</p>
<p align="center">
  <img src="demo/synwaveco-place-order.jpg" alt="Checkout Form" width="900"/>
  <br/>
  <em>Checkout details page for shipping configuration and payment selection</em>
</p>

<p align="center">
  <img src="demo/synwaveco-place-order-success.jpg" alt="Order Success Invoice" width="900"/>
  <br/>
  <em>Order completed page displaying the transactional invoice</em>
</p>

<details>
  <summary>🔍 View Detailed Cart & User Profile Pages</summary>

  <p align="center">
    <img src="demo/shoppingcard.jpg" alt="Off-canvas Cart" width="900"/>
    <br/>
    <em>Off-canvas cart drawer sliding from the right edge for quick updates</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-shoppingcard.jpg" alt="Full Shopping Cart Page" width="900"/>
    <br/>
    <em>Full cart page supporting coupon codes, quantity modifiers, and price calculators</em>
  </p>

  <p align="center">
    <img src="demo/user-profile.jpg" alt="User Profile Page" width="900"/>
    <br/>
    <em>User dashboard displaying orders history, personal settings, and owned IoT devices</em>
  </p>
</details>

---

### 3. Knowledge Hub (Tri thức & Giải pháp)
Resources sharing guides, hardware assembly tips, and code blocks:

<p align="center">
  <img src="demo/synwaveco-articles-01.jpg" alt="Articles List" width="900"/>
  <br/>
  <em>Knowledge Hub listing smart solutions and IoT tutorials</em>
</p>

<details>
  <summary>🔍 View Article Details & Filtering</summary>

  <p align="center">
    <img src="demo/article-detail.jpg" alt="Article Detail View" width="900"/>
    <br/>
    <em>Detailed tutorial view rendering code snippets and inline layout diagrams</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-articles-02.jpg" alt="Smart Farming Guides" width="900"/>
    <br/>
    <em>IoT case studies concentrating on smart irrigation and agricultural automation</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-article-filter-by-topic.jpg" alt="Filter by Topic" width="900"/>
    <br/>
    <em>Sorting articles by topics (e.g., Smart Home, Agriculture, Dev Boards)</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-article-filter-by-type.jpg" alt="Filter by Article Type" width="900"/>
    <br/>
    <em>Filtering by category tags: Technical Tutorial, Product Review, Tech News</em>
  </p>
</details>

---

### 4. Admin Management Dashboard

#### 🛠️ Dashboard & IoT Telemetry Controls
<p align="center">
  <img src="demo/synwaveco-administrator-iot-devices.jpg" alt="IoT Device Manager" width="900"/>
  <br/>
  <em>IoT Device management: Registering nodes, linking MAC addresses, and assigning to customers</em>
</p>

<p align="center">
  <img src="demo/synwaveco-administrator-products.jpg" alt="Admin Products List" width="900"/>
  <br/>
  <em>Products management dashboard for managing listings and updating tech specs sheets</em>
</p>

<details>
  <summary>🔍 View Full Suite of Admin Operations</summary>

  <p align="center">
    <img src="demo/synwaveco-administrator-users.jpg" alt="User Management" width="900"/>
    <br/>
    <em>User management table allowing roles allocation and account tracking</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-administrator-roles.jpg" alt="Roles Configuration" width="900"/>
    <br/>
    <em>System roles dashboard defining routes access keys for Admins, Salers, and Shippers</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-administrator-order.jpg" alt="Order Management" width="900"/>
    <br/>
    <em>Orders panel for review, invoicing, status overrides, and assignment to shippers</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-administrator-order-status.jpg" alt="Order Statuses" width="900"/>
    <br/>
    <em>Configuring transactional steps: Pending, Processing, Shipping, Delivered, Canceled</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-administrator-categories.jpg" alt="Categories Manager" width="900"/>
    <br/>
    <em>Categories configuration for structural classification of electronic components</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-administrator-manufacturers.jpg" alt="Manufacturers Panel" width="900"/>
    <br/>
    <em>Managing manufacturer records and hardware brand directories</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-administrator-articles.jpg" alt="Articles Dashboard" width="900"/>
    <br/>
    <em>Drafting, editing, and publishing guide posts with CKEditor 5</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-administrator-topics.jpg" alt="Topics Manager" width="900"/>
    <br/>
    <em>Managing community topics and article discussion tags</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-administrator-article-types.jpg" alt="Article Types" width="900"/>
    <br/>
    <em>Defining article formats (e.g., Quick News, Assembly Tutorial, Review)</em>
  </p>

  <p align="center">
    <img src="demo/synwaveco-administrator-article-statuses.jpg" alt="Article Statuses" width="900"/>
    <br/>
    <em>Review flow for articles: Draft, Pending Review, Published, Hidden</em>
  </p>
</details>

---

## 🛠️ Technology Stack

| Layer | Technology / Library | Version | Role / Application |
| --- | --- | :---: | --- |
| **Back-end Core** | Laravel Framework | 12.x | MVC infrastructure handling security (CSRF/XSS), routing, database queries, and middleware. |
| **Language** | PHP | 8.2+ | Primary development language. |
| **Database** | MySQL / MariaDB | 8.0+ | Relational data engine with indexation and schema constraints. |
| **Front-end UI** | Bootstrap, HTML5/CSS3, JS | 5.3 | Responsive layouts styled through Blade templates and Cartzilla templates. |
| **Shopping Cart** | anayarojo/shoppingcart | 4.2 | Server-side cart management package. |
| **Document Processing**| Maatwebsite/Laravel-Excel | 3.1 | Handles Excel import and CSV export functions. |
| **Rich Text Editor** | CKEditor 5 | N/A | Full text editor with code highlight capability. |
| **Social Login** | Laravel Socialite | 5.24 | Social login adapters (Google, Facebook). |
| **Bundler** | Vite | Modern | Compiles assets and builds JavaScript packages. |

---

## 🗃️ Database Schema

The database design links e-commerce activities with post-sale IoT hardware monitoring:

*   **`users`**: Contains credential info, having a `1-N` relationship with `orders`.
*   **`roles`**: Contains system access roles (Admin, Saler, Shipper, Customer), having a `1-N` relationship with `users`.
*   **`products`**: Commercial inventory records (price, inventory, description).
*   **`product_details`**: Has a `1-1` relationship with `products`, holding hardware specifications (CPU, RAM, power limits, connections).
*   **`orders` & `order_items`**: Handles checkout history, invoice generation, and product price snapshots at order time.
*   **`iot_devices`**: Deployed hardware details (assigned customer, UUID, location info), having a `1-N` relationship with `device_metrics`.
*   **`device_metrics`**: Logs incoming sensor data (humidity, temperature, light, state).
*   **`alert_thresholds`**: Stores upper and lower bounds for sensor alarms.

---

## 📁 Project Directory Structure

Standard Laravel architecture with document assets in root directory:

```
D:\Study\E-commerce\Project\
├── src/                               # Laravel Application source directory
│   ├── app/                           # Core application logic
│   │   ├── Http/
│   │   │   ├── Controllers/           # Controller endpoints (e.g. IoTDevicesController.php, OrdersController.php)
│   │   │   └── Middleware/            # Custom Middleware filters (RoleMiddleware.php)
│   │   ├── Models/                    # Eloquent database models (Product.php, Order.php, IoTDevice.php...)
│   │   └── Mail/                      # Mail templates (PlaceOrderSuccessEmail.php)
│   ├── bootstrap/                     # App boot files
│   ├── config/                        # Laravel global configuration files
│   ├── database/                      # Migrations and Seeders
│   │   ├── migrations/                # Database tables creation scripts
│   │   └── seeders/                   # Seeder classes injecting sample dataset
│   ├── public/                        # Publicly accessible directory
│   │   ├── assets/                    # Compiled assets for Cartzilla UI
│   │   └── storage/                   # Media files symlink
│   ├── resources/
│   │   └── views/                     # Blade template view files
│   │       ├── administrator/         # Admin views (IoT Devices setup, user tables, configurations)
│   │       ├── saler/                 # Saler views (Product listings, order management)
│   │       ├── shipper/               # Shipper views (Delivery tracking)
│   │       ├── frontend/              # Home pages, article libraries, product lists
│   │       └── user/                  # Customer profile and checkout layouts
│   ├── routes/
│   │   └── web.php                    # HTTP Route mappings
│   ├── composer.json                  # PHP dependency mappings (Laravel 12 dependencies)
│   └── package.json                   # JS/CSS dependencies
├── demo/                              # Folder containing 34 system mockups & screenshots
├── docs/                              # Auxiliary documentation files
├── products-list.xlsx                 # Excel sheet with demo products list for bulk import
├── Demo.pptx                          # Presentation slides of SynWaveEco
├── Project-Document.docx              # Comprehensive systems analysis & design documentation
├── .gitignore                         # Project-wide git exclusion file
└── README.md                          # Current file
```

---

## ⚙️ Setup & Installation Guide

Follow these steps to run the SynWaveEco application in your local development environment:

### 1. Requirements
*   **PHP:** Version `>= 8.2`
*   **Composer:** Version `2.x`
*   **Node.js & NPM:** (LTS version recommended)
*   **MySQL / MariaDB:** Version `>= 8.0`
*   **Web Server Environment:** Apache, Nginx, or Laragon/XAMPP.

### 2. Step-by-Step Setup

#### Step 1: Clone the repository
Open your terminal, navigate to the target directory, and clone the project:
```bash
git clone [repository_url] synwaveco-app
cd synwaveco-app
```

#### Step 2: Install PHP dependencies
Go to the `src` folder and run Composer:
```bash
cd src
composer install
```

#### Step 3: Set up the `.env` file
Duplicate the example environment file and generate the application encryption key:
```bash
cp .env.example .env
php artisan key:generate
```

#### Step 4: Configure the MySQL Database
Open `.env` in your text editor and specify your database details:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=synwaveco_ecommerce   # Create this database in your MySQL engine
DB_USERNAME=root                 # Your database username
DB_PASSWORD=                     # Your database password
```
*(Make sure to create an empty schema named `synwaveco_ecommerce` in your database engine before running migrations).*

#### Step 5: Run Migrations and Seeders
Build database structures and seed default roles, credentials, and products:
```bash
php artisan migrate --seed
```

#### Step 6: Create the Storage Symlink
Link the private storage folder to public folder to enable product image display:
```bash
php artisan storage:link
```

#### Step 7: Build assets with Vite
```bash
npm install
npm run build
```

#### Step 8: Start the local server
```bash
php artisan serve
```
The application will start at: **http://127.0.0.1:8000**

---

## 🔑 Sample Login Credentials

Pre-loaded accounts representing each of the 4 roles:

| Username | Password | Role | Description & Scope of Access |
| --- | --- | :---: | --- |
| `admin` | `password` | **Administrator** | Full backend control: system configurations, user role assignments, IoT nodes registrations, Excel bulk imports/exports, and article reviews. |
| `fengshuiying` | `password` | **Saler (Sales)** | Sales actions: add/update products, edit manufacturer info, and approve order statuses. |
| `linsiruip` | `password` | **Shipper (Delivery)**| Delivery logistics: View assigned orders and update shipping states (Delivering, Delivered). |
| `yuzhangyou` | `password` | **Customer (User)**| Basic customer actions: browse products, filter technical specs, checkout orders, write reviews, and access personal IoT devices panel. |

---

## 🚀 Strategic Initiatives & Real-World Impact

SynWaveEco is designed to provide actionable value:
*   **Precision Agriculture Adoption:** Supports smallholder farms in regions like the Mekong Delta with cost-effective, smart kits (soil humidity sensors, auto-pumps) to make farming data-driven.
*   **Preventative Hardware Protection:** The early warning alarms configured through `alert_thresholds` allow users to solve electrical issues or thermal anomalies before devices get damaged.
*   **Hardware Integration Design:** The REST API layout is fully prepared to receive live telemetry reports via standard IoT protocols (MQTT, HTTP POST) from physical controllers like ESP32, Arduino Uno WiFi, or Raspberry Pi.

---

## 🎓 Author & Developer

The **SynWaveEco** project is an academic-practical hybrid application designed, researched, and built by:
*   **Author:** **Huỳnh Quốc Huy** (Student of Information Technology, Department of Engineering - Technology - Environment, An Giang University - AGU)
*   **Email:** [huykyunh.k@gmail.com](mailto:huykyunh.k@gmail.com)
*   **GitHub:** [github.com/hkhuang07](https://github.com/hkhuang07)

Key development accomplishments:
1.  Mastered modern MVC design patterns via PHP Laravel 12 and Vite.
2.  Designed normalized database architectures supporting cascading relational integrity.
3.  Constructed dynamic front-ends utilizing responsive UI principles.
4.  Created multi-channel distribution plans matching target user personas.

---
<div align="center">
  <h3>🌊💚 SynWaveEco</h3>
  <p><em>Beyond Connectivity, Building Tomorrow's Smart Ecosystem</em></p>
  <p><strong>Made with ❤️ by Huỳnh Quốc Huy - 2026</strong></p>
</div>
