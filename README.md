#  **  UserPortal  ** 🎉

## **Overview**

UserPortal  is a dynamic, next-generation customer management system built for modern businesses. This project integrates seamless **OAuth authentication** using Google, allowing users to log in effortlessly. It also provides a smooth customer registration process, along with WhatsApp API integration for customer confirmation and easy interaction.

The application features **CRUD operations** for managing customers, an **admin dashboard** for viewing user actions, and **webhook integration** to notify admins about new form submissions. Built using **PHP**, **MySQL**, and **Bootstrap**, the platform aims to empower businesses with a scalable and intuitive portal.

---

## **Features**

### 1. **OAuth Authentication with Google** ✨
   - Seamless user authentication using Google OAuth.
   - Automatically retrieves user profile information to simplify the registration process.
  
### 2. **Customer Details Submission Form** 📋
   - Simple and clean UI for submitting customer details.
   - Built-in client-side and server-side validation for key fields such as phone number, email, and date of birth.

### 3. **WhatsApp Integration** 📱
   - After form submission, a prefilled WhatsApp message is generated.
   - Allows the user to verify their details and communicate directly with the business.

### 4. **Admin Dashboard** 🛠️
   - A powerful interface for admins to manage customers, including adding, editing, and deleting records.
   - View customer lists with pagination support for easy navigation of large datasets.

### 5. **Webhook Integration** 🌐
   - Triggers webhooks to notify admins of new form submissions in real-time.
   - All logs of new submissions are recorded in `webhook_logs.txt`.

### 6. **Admin Logs** 📜
   - Logs key actions performed by admins, such as customer registrations and updates.
   - Admin logs are displayed with timestamp information for easy monitoring.

### 7. **Elegant User Interface (UI)** 🎨
   - A dark-themed design built with **Bootstrap 5**, providing an attractive, modern, and responsive interface.
   - Includes hover effects, animations, and optimized UI elements for an enhanced user experience.

---

## **Tech Stack** 💻

- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend:** PHP (v7+), MySQL
- **Authentication:** Google OAuth 2.0
- **Database:** MySQL
- **API Integration:** WhatsApp API for customer confirmation
- **Server Logs:** PHP error handling and logging for webhook activity

---

## **Getting Started** 🚀

### **Prerequisites**

Before you start, ensure you have the following installed:
- **Apache/Nginx** (as your web server)
- **PHP 7+** (or higher)
- **MySQL**
- **Composer** (for managing dependencies)

### **Installation**

1. **Clone the Repository**
   ```bash
   git clone https://github.com/Apocalypse96/UserPortal.git
   cd UserPortal
   ```

2. **Database Setup**
   - Create a new MySQL database:
     ```bash
     CREATE DATABASE userportalpro;
     ```
   - Import the provided SQL file to set up the database schema:
     ```bash
     mysql -u root -p userportalpro < /path/to/schema.sql
     ```

3. **Configure Environment Variables**
   - Rename the `config/config.example.php` to `config/config.php` and update the database credentials, Google OAuth settings, and webhook URLs.

4. **Start the Server**
   ```bash
   php -S localhost:8000
   ```

5. **Access the Project**
   - Open your browser and navigate to [http://localhost:8000](http://localhost:8000) to see the application in action.

---

## **How It Works** ⚙️

### **Authentication**
- Users can log in using Google OAuth, which securely retrieves user details and stores them in the database.

### **Form Handling & WhatsApp API**
- After submitting the customer form, a WhatsApp message is prefilled with the submitted details, allowing easy communication.

### **Webhook Notification**
- On successful form submission, a webhook event is triggered to notify the admin with the details of the new submission.

---

## **Project Structure** 🗂️

```
UserPortalPro/
├── config/
│   └── config.php           # Configuration files (Database, OAuth)
├── public/
│   ├── css/                 # Custom stylesheets
│   ├── js/                  # JavaScript and validation scripts
│   ├── webhooks/            # Webhook handler for admin notifications
│   │   └── webhook_handler.php
├── includes/
│   └── db.php               # Database connection file
│   └── form-handler.php      # Main form handling logic
├── templates/
│   ├── admin_dashboard.php  # Admin dashboard page
│   └── thankyou.php         # Thank you page post submission
└── README.md                # Project documentation
```

---

## **Admin Credentials** 🔑

To access the admin panel, log in using your Google account that is registered as an admin in the `admins` table of the database.

---

## **To Do** ✅

- Implement more third-party API integrations.
- Expand webhook functionality for additional events.
- Add more customization options for the admin panel.

---
