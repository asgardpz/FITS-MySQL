MFIS — Manufacturing Factory Integration System

<p align="center">
  <h1 align="center">🏭 MFIS</h1>
  <p align="center">
    <strong>Manufacturing Factory Integration System</strong><br>
    A PHP-based Smart Factory Management and Data Integration Platform
  </p>
</p>

MFIS 是以 PHP / Laravel 為核心的通用智慧工廠管理與資料整合平台，提供生產資訊整合、工單管理、設備資料串接、製程追蹤及管理看板等功能。

本專案以通用製造業流程為設計方向，透過模組化方式整合企業既有的 ERP、MES、設備系統及資料庫，可依不同產業與工廠需求擴充功能。

Project Scope
MFIS 定位為通用智慧工廠平台示範專案。畫面、資料與流程可使用模擬資料展示；實際 ERP、MES、設備或資料庫連線，須依導入環境另行設定與開發。

⸻

✨ Features

* 📊 Dashboard — 生產資訊與設備狀態總覽
* 🔍 Work Order Management — 工單查詢及工單資訊整合
* 🏭 Production Management — 生產流程與製程資訊管理
* ⚙️ Equipment Integration — 設備資料介接與狀態監控
* 🔗 System Integration — ERP、MES、WMS 等企業系統資料整合
* 🧾 Traceability — 工單、物料、批號及製程履歷追蹤
* 📈 Reports & Analytics — 生產統計及管理報表
* 🔌 API Integration — 透過 API 與外部系統交換資料

功能模組可依專案需求增減，不限定特定產品、設備或製造產業。

⸻

🏗 System Architecture

MFIS 採用分層與模組化設計，以 Laravel 作為主要 Web 應用程式，透過 API 或資料介接服務與外部系統溝通。

        +------------------+
        |       ERP        |
        +---------+--------+
                  |
        +---------v--------+
        |       MES        |
        +---------+--------+
                  |
        +---------v--------+
        | External Systems |
        | WMS / Equipment  |
        | Database / API   |
        +---------+--------+
                  |
          API / Data Adapter
                  |
        +---------v--------+
        |       MFIS       |
        |   PHP / Laravel  |
        +---------+--------+
                  |
     +------------+-------------+
     |            |             |
+----v-----+ +----v-----+ +-----v------+
|Dashboard| |Production| | Traceability|
+----------+ +----------+ +------------+
                  |
        +---------v--------+
        |   MySQL Database |
        +------------------+

Architecture Notes

* MFIS：負責 Web 操作介面、管理功能、資料彙整及流程呈現。
* API / Data Adapter：負責外部系統或設備資料的交換與轉換。
* ERP / MES / WMS：依實際環境提供工單、物料、生產及庫存等資料。
* MySQL：儲存 MFIS 本身所需的管理資料及整合後資料。
* 外部系統可依環境採用 API、資料庫檢視、檔案交換或其他核准的介接方式。

⸻

📷 Demo Screenshots

以下區域可放置 MFIS 實際執行畫面。若目前尚未提供截圖，可先保留章節，待畫面完成後再補上圖片。

Home

<!-- ![MFIS Home](images/home.png) -->

* 系統入口與平台介紹
* 登入及帳號相關功能

Login

<!-- ![MFIS Login](images/login.png) -->

* 使用者登入介面
* 系統存取入口

Dashboard

<!-- ![MFIS Dashboard](images/dashboard.png) -->

* 生產資訊總覽
* 管理功能入口
* 重要資訊及狀態摘要

Production Management

<!-- ![Production Management](images/production_management.png) -->

* 工單及生產資訊查詢
* 製程資料管理

Equipment Integration

<!-- ![Equipment Integration](images/equipment_integration.png) -->

* 設備資訊整合
* 設備狀態及資料監控

Traceability

<!-- ![Traceability](images/traceability.png) -->

* 工單、物料或批號查詢
* 生產履歷追蹤

⸻

📂 Project Structure

以下為建議的專案目錄配置，實際內容依目前版本及模組開發情況調整。

MFIS/
│
├── app/                    # Laravel application
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── images/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
├── storage/
├── tests/
├── .env.example
├── composer.json
└── README.md

⸻

🗄 Data Sources & Integration

Source	Description
ERP	工單、產品及物料等企業資源資料
MES	生產工單、製程及生產執行資料
WMS	倉儲、庫存及物料異動資料
Equipment	設備狀態、運轉資訊及製程資料
MySQL	MFIS 平台管理及整合資料
External API	與其他企業系統或服務交換資料

實際介接項目與資料欄位，依各工廠既有系統及授權範圍規劃。

⸻

💻 Technology Stack

Category	Technology
Backend	PHP
Framework	Laravel
Database	MySQL
Frontend	HTML / CSS / JavaScript
UI	Bootstrap
Integration	RESTful API / Data Adapter
Version Control	Git

⸻

🚀 Roadmap

* [ ]	Production Dashboard
* [ ]	Work Order Management
* [ ]	Material Tracking
* [ ]	Equipment Monitoring
* [ ]	Production Traceability
* [ ]	SPC / Quality Analysis
* [ ]	Yield Analytics
* [ ]	Energy Management
* [ ]	Report Center
* [ ]	External ERP / MES / WMS API Integration

⸻

🧩 Positioning

MFIS 是通用智慧工廠管理平台的示範與開發基礎，可依不同產業建立延伸應用，例如：

* 電子製造
* 零組件加工
* 紡織製造
* 一般離散製造

產業別功能可透過獨立模組擴充，不需要將平台核心綁定於單一工廠或特定公司的系統。

⸻

📄 License

This project is provided as a general-purpose smart factory demonstration and development project.

除另有明確授權或標示外，請勿將本專案內容視為任何公司內部系統、商業資料或第三方軟體的授權副本。使用第三方套件、函式庫或範例程式時，應遵守其各自的授權條款。

⸻

<p align="center">
  <strong>MFIS — Manufacturing Factory Integration System</strong><br>
  <sub>Modular · Extensible · Integration-oriented</sub>
</p>
