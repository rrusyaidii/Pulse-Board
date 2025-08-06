# Debugs Thugs – ZANKO Hackathon 2025 Submission



---

## 🧠 Problem Statement

Our team faced the following issues in real-life project management:

1. **Inefficient Task Handover**  
   Lack of accessible task history and context makes team transitions manual and time-consuming.

2. **Limited Historical Tracking**  
   No centralized way to view past issues or development activity logs.

3. **Difficulty in Progress Tracking**  
   Hard to monitor team or individual task progress effectively.

4. **Methodology Mismatch**  
   Agile principles are applied, but task visibility and tracking are missing, leading to confusion and poor alignment.

---

## 💡 Solution

**Pulse Board** provides:

- 🗂 **Kanban-style project boards** for better visibility  
- 🔄 **Task history tracking** to simplify handovers  
- 📊 **Progress monitoring** at project and member levels  
- 🌐 **Simple REST API** to integrate with external tools  
- 🧩 **Lightweight, self-hosted, and PHP-based** for quick deployment

---

## ⚙️ Tech Stack

- **Backend**: CodeIgniter 4 (PHP 8.1.12)
- **Database**: MySQL / MariaDB
- **Frontend**: Bootstrap 5 + jQuery
- **API**: REST API

---

## 🚀 Installation & Setup

### **Requirements**

- PHP **8.1.12** or higher  
- Composer **2.x**  
- MySQL / MariaDB  
- Apache / Nginx with `mod_rewrite` enabled  

---

### **1. Clone the repository**

```bash
git clone https://github.com/yourusername/pulse-board.git
cd pulse-board
``` 

## Configure environment
### Copy .env.example to .env (or update app/Config/Database.php):
```bash 
composer install
```
### Update the following in .env:
```bash 
cp env .env
```

```bash 
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = pulse_board
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```