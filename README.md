# Debugs Thugs – ZANKO Hackathon 2025 Submission

---

## 🧠 Problem Statement

1. **Inefficient Task Handover**  

2. **Limited Tracking and Progress Visibility**  

3. **Difficulty in Progress Tracking**  

4. **Methodology Mismatch**  

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

### **2. Install dependencies**
Run following command
```bash 
composer install
```
### **3. Configure environment**
** Copy .env.example to .env (or update app/Config/Database.php):**
```bash 
cp env .env
```
 Update the following in .env:

```bash 
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = pulse_board
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### **4. Import the database into the DB**
```bash
pulseboard.sql
```
### **5. Start the development server**
```bash
php spark serve
```
---
## 👥 Team & Acknowledgements
- Developed during Hackathon 2025
- Inspired by issues faced in real development workflows
- Mentor: Cik Mimi
- Team Members: Faiz Aiman (Team Lead/Developer) , Nur Afiqah (Developer) ,Haziq Rusyaidi (Developer), Nur Syazlin (System Analyst) ,Husna Umairah(System Analyst)



