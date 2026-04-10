# CarZone Backend API 🚗

[English Documentation](#english) | [الوثائق باللغة العربية](#arabic)

---

<a id="english"></a>
## 🇬🇧 English Documentation

CarZone is a modern backend application built with the Laravel framework. It provides a robust API to manage cars (products), vehicle brands, regional areas (provinces), and user authentication.

### 🎯 Features
- **User Authentication:** Registration, Login, and Google Auth integration using Laravel Sanctum.
- **Product Management:** Complete API to manage vehicle listings (CRUD).
- **Brands & Provinces:** Categorize models by automobile manufacturers and regional availability.
- **Media Handling:** Manages images and files utilizing Spatie Media Library.
- **API Documentation:** Generated automatically via Scribe (`/docs`).

### 🛠️ Tech Stack & Architecture
- **Framework:** Laravel 12.x (PHP 8.2+)
- **Architecture Pattern:** Clean architecture using **Repository** and **Service** patterns. This ensures business logic and database access are kept separate from the controllers.
- **Authentication:** Laravel Sanctum
- **Database:** MySQL / SQLite

### 📁 Project Structure

This project follows an organized, scalable folder structure:

```text
CarZone/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/      # Controllers for admin dashboard operations
│   │   │   └── Api/        # Controllers for public client API requests
│   │   └── Requests/       # Form Request validations (e.g., StoreProductRequest)
│   ├── Models/             # Database Models (User, Product, Brand, Province)
│   ├── Repository/         # Data Access Layer (handles database queries)
│   └── Services/           # Business Logic Layer (handles core operation logic)
├── database/
│   └── migrations/         # Database schema creation files
├── routes/
│   ├── api.php             # API route definitions
│   └── web.php             # Web UI route definitions
└── config/                 # Application configuration (Scribe, Media Library, etc.)
```

### 🚀 Installation & Setup

1. **Clone the repository** (or extract the project files).

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install and build frontend dependencies:**
   ```bash
   npm install
   npm run build
   ```

4. **Environment Setup:**
   Copy the example environment file and configure your database settings `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
   ```bash
   cp .env.example .env
   ```

5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations (Database Setup):**
   ```bash
   php artisan migrate
   ```

7. **Start the Development Server:**
   ```bash
   php artisan serve
   ```
   *Your application API will be accessible locally at `http://localhost:8000`.*

### 📄 API Endpoints Example

- `POST /api/register` - Create a new user account.
- `POST /api/login` - Authenticate a user and receive a token.
- `GET /api/products` - List all listed vehicles (Public).
- `POST /api/products` - Add a new vehicle (Requires Sanctum Token).
- `GET /api/brands` - List all available car brands.
- `GET /api/provinces` - List all provinces.

*(Detailed documentation is available at `/docs` when the server is running).*

---

<a id="arabic"></a>
## 🇸🇦 الوثائق باللغة العربية

**CarZone (كار زون)** هو تطبيق (Backend) حديث ومبني باستخدام إطار عمل Laravel. يقدم التطبيق واجهة برمجة تطبيقات (API) قوية لإدارة السيارات (المنتجات)، العلامات التجارية للمركبات، المناطق/المحافظات، بالإضافة إلى نظام مصادقة آمن للمستخدمين.

### 🎯 المميزات الأساسية (Features)
- **مصادقة المستخدمين:** التسجيل، تسجيل الدخول، والمصادقة باستخدام جوجل (Google Auth) باستخدام Laravel Sanctum.
- **إدارة المنتجات:** واجهة متكاملة لإدارة إعلانات المركبات وخصائصها (إنشاء، قراءة، تحديث، حذف).
- **العلامات التجارية والمحافظات:** تصنيف المركبات بناءً على مصنعي السيارات والتوافر الجغرافي.
- **التعامل مع الوسائط:** إدارة الصور والملفات الملحقة باستخدام حزمة Spatie Media Library.
- **توثيق الواجهة (API Docs):** توثيق تلقائي وجاهز لمسارات النظام عبر حزمة Scribe (متاح عبر الرابط `/docs`).

### 🛠️ التقنيات وهيكلة المشروع (Tech Stack & Architecture)
- **إطار العمل:** Laravel 12.x (PHP 8.2+)
- **بنية المشروع (Architecture Pattern):** تم الاستعانة بمعمارية الكود النظيف بتطبيق تصميمي الـ **Repository** و الـ **Service**. هذه الهيكلة تضمن فصل عمليات استعلام قواعد البيانات (Repository) وعمليات المعالجة المنطقية (Services) بشكل كامل عن أجهزة التحكم (Controllers).
- **نظام المصادقة:** Laravel Sanctum.
- **قواعد البيانات:** MySQL / SQLite.

### 📁 هيكلة المجلدات 

يتبع المشروع هيكلاً منظماً يدعم قابلية التوسع للأنظمة الكبيرة:

```text
CarZone/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/      # أجهزة التحكم الخاصة بعمليات لوحة الإدارة (Admin)
│   │   │   └── Api/        # أجهزة التحكم الخاصة بالواجهة البرمجية للعميل (API)
│   │   └── Requests/       # كلاسات التحقق من صحة المدخلات (Form Requests)
│   ├── Models/             # النماذج لتمثيل جداول قاعدة البيانات (User, Product, Brand, Province)
│   ├── Repository/         # طبقة قواعد البيانات (Repository Layer لإجراء الاستعلامات)
│   └── Services/           # طبقة الخدمات (Services Layer لمعالجة العمليات البرمجية الأساسية)
├── database/
│   └── migrations/         # ملفات التهجير لإنشاء وبناء جداول قواعد البيانات
├── routes/
│   ├── api.php             # مسارات الـ API (نقاط الوصول الخاصة بالبيانات)
│   └── web.php             # مسارات الويب التقليدية وواجهات العرض
└── config/                 # ملفات الإعداد الخاصة للنظام وللحزم المثبتة
```

### 🚀 التثبيت والتشغيل

1. **قم بتحميل المشروع (Clone repository)** أو فك ضغط مجلد التطبيق.

2. **تثبيت حزم الـ PHP الأساسية (Composer):**
   ```bash
   composer install
   ```

3. **تثبيت حزم الـ Node.js الأمامية وبناء الواجهة:**
   ```bash
   npm install
   npm run build
   ```

4. **إعدادات البيئة (Environment):**
   قم بنسخ ملف البيئة وأدخل بيانات قاعدة البيانات الخاصة بك في المتغيرات: `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
   ```bash
   cp .env.example .env
   ```

5. **توليد مفتاح التطبيق (App Key):**
   ```bash
   php artisan key:generate
   ```

6. **تهيئة قاعدة البيانات (Migrations):**
   ```bash
   php artisan migrate
   ```

7. **بدء تشغيل خادم التطوير الخفيف:**
   ```bash
   php artisan serve
   ```
   *سيكون التطبيق ومسارات الـ API الخاص بك متاحاً على الرابط `http://localhost:8000`.*

### 📄 أمثلة على الروابط والمسارات (API Endpoints)
- `POST /api/register` - تسجيل مستخدم جديد في النظام.
- `POST /api/login` - تسجيل الدخول والحصول على رمز الجلسة الآمن (Token).
- `GET /api/products` - استعراض كافة المركبات المعروضة (مسار مفتوح للكل).
- `POST /api/products` - إضافة مركبة جديدة (مسار محمي - يتطلب توثيق وتسجيل الدخول).
- `GET /api/brands` - قائمة بجميع العلامات التجارية المتوفرة.
- `GET /api/provinces` - قائمة بالمحافظات والمناطق.

*(التوثيق الكامل والتفاعلي للواجهة متوفر ومتاح للتجربة على الرابط `/docs` بمجرد تشغيل المشروع).*

---
## 📜 License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
