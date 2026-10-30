# MFIS - Manufacturing Factory Integration 

<p align="center">

# 🏭 MFIS
### Manufacturing Factory Integration System

**Smart Factory Management Platform for IC Programming & Manufacturing Traceability**

整合 **MES、ERP、設備**，
提供完整 流程追蹤、設備管理與智慧製造資訊整合平台。

---

## ✨ Features

- 📊 Dashboard 即時資訊看板
- 🔍 工單查詢
- 📄 工單資訊整合
- ⚙️ 設備操作管理
- 🏷 ID 追溯
- 📈 生產資訊整合
- 🔄 MES / ERP / 設備 資料整合

---

# 🏗 System Architecture


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
                   |    MFIS     |
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
- MFIS 首頁
- 登入介面

---

## Dashboard


- Dashboard
- 功能入口
- Logout

---

## Programming Menu

- 功能清單
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
MFIS/
│
├── Laravel/
├── MESApi/
├── EQPApi/
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
| LiteDB | EQP+ Programming Machine |
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
