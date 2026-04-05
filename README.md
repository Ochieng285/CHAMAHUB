# ChamaHub 🇰🇪 💃
**A Transparent, Secure, and Automated Financial Tracking System for Women's Chamas.**

ChamaHub is a web-based platform designed to digitize the traditional "Chama" (investment group) contribution process. It eliminates the need for messy paper ledgers and fragmented WhatsApp messages by providing a central digital ledger with automated verification.

---

## ✨ Key Features

### 👩‍💻 For Members
* **Personal Dashboard:** View your total lifetime savings and community progress in real-time.
* **Smart Contribution Uploads:** Submit M-Pesa or bank screenshots directly to the platform.
* **Auto-Verification:** The system uses OCR (Optical Character Recognition) to match your uploaded screenshot with the amount you entered.
* **History Tracking:** A complete, unchangeable record of every payment you have ever made.

### 👑 For Admins (Treasurers)
* **Automated Bookkeeping:** The system handles all the math, showing total group contributions instantly.
* **Verification Queue:** A clear list of "Pending" and "Flagged" payments that need human review.
* **Transparency:** Reduces disputes by maintaining a "Proof of Payment" gallery for every transaction.

---

## 🛠️ Tech Stack
* **Frontend:** HTML5, Tailwind CSS (for modern, responsive UI), JavaScript.
* **Backend:** PHP 8.x
* **Database:** MySQL (relational storage for users and payments).
* **Integration:** OCR.space API (for automated receipt reading).
* **Security:** Bcrypt password hashing and PDO prepared statements to prevent SQL injection.

---

## 🚀 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/yourusername/chamahub.git](https://github.com/yourusername/chamahub.git)
