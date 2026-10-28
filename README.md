# FITS — Factory Intelligent Tracking System

<p align="center">

# 🏭 FITS
### Factory Intelligent Tracking System

**Smart Factory Management Platform for IC Programming & Manufacturing Traceability**

整合 **MES、ERP、自動燒錄機、LiteDB、BarTender**，
提供完整 IC 燒錄流程追蹤、設備管理與智慧製造資訊整合平台。

---

## ✨ Features

- 📊 Dashboard 即時資訊看板
- 🔍 IC 燒錄工單查詢
- 📄 工單資訊整合
- ⚙️ 設備操作管理
- 🏷 Reel ID 追溯
- 📈 生產資訊整合
- 🔄 MES / ERP / DP3T+ 資料整合

---

# 🏗 System Architecture

> 依據 FITS.docx 內容整理。

```
                 +----------------+
                 |      ERP       |
                 +--------+-------+
                          |
+---------+       +--------v-------+      +-------------+
| LiteDB  |------>|     MESApi     |<-----|     MES     |
+---------+       +--------+-------+      +-------------+
                          |
                   +------v------+
                   |    FITS     |
                   +------+------+
                          |
          +---------------+---------------+
          |       |        |        |      |
      Dashboard Query  Detail  Device  Reports
                          |
                   +------v------+
                   | BarTender   |
                   +-------------+
```

---

# 📷 Demo Screenshots


## Home



- Logo
- 打字效果系統介紹
- 跑馬燈功能介紹
- Login / Sign Up

---

## Login



- 官網連結
- FITS 首頁
- 登入介面

---

## Dashboard


- Dashboard
- 功能入口
- Logout

---

## IC Programming Menu

- IC 燒錄功能清單
- 收合 / 展開

---

## Work Order Query

資料來源：

- MES
- Reel ID（BarTender）

---

## Work Order Detail


整合：

- ERP
- MES
- LiteDB

---

## Device Operation


流程：

1. Scan Reel ID
2. Work Order
3. Fixture
4. Nozzle
5. Tape
6. Validation
7. Start

---

# 📂 Project Structure

```text
FITS/
│
├── Laravel/
├── MESApi/
├── DP3TApi/
├── images/
│   ├── architecture.png
│   ├── home.png
│   ├── login.png
│   ├── dashboard.png
│   ├── menu.png
│   ├── workorder_query.png
│   ├── workorder_detail.png
│   └── device_operation.png
├── README.md
```

---

# 🗄 Data Sources

| Source | Description |
|--------|-------------|
| MES | Manufacturing Execution System |
| ERP | Work Order / Material Information |
| LiteDB | DP3T+ Programming Machine |
| BarTender | Reel ID Traceability |

---

# 💻 Technology Stack

| Category | Technology |
|----------|------------|
| Backend | ASP.NET Core Web API |
| Web | Laravel |
| Database | MySQL / Oracle / LiteDB |
| Frontend | HTML / CSS / JavaScript |
| UI | Bootstrap |

---

# 🚀 Roadmap

- AI Dashboard
- SPC Analysis
- Yield Analytics
- Equipment Monitoring
- Predictive Maintenance
- Report Center

---

# 📄 License

This project is for demonstration and internal manufacturing integration purposes.

---

> README generated from the current FITS system architecture and function description in FITS.docx.
