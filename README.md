# Iuran Warga App

**Iuran Warga App** is a web application built with **Laravel** to manage community contributions (iuran warga) for local administrative purposes. The system features two types of users: **Admin** and **Regular User**. Admins have full control over the application, including managing user accounts and overseeing contributions, while regular users can view and update their own contribution records.

The app utilizes **MySQL** (via **XAMPP**) for data storage and supports **CRUD (Create, Read, Update, Delete)** operations. Additionally, it enables **Excel** and **PDF exports** for generating contribution reports.

---

## Key Features

- **Admin and User Roles**: Role-based access control, with different levels of permissions for Admins and Regular Users.
- **CRUD Operations**: Efficient management of contribution records with capabilities to create, read, update, and delete entries.
- **Excel & PDF Export**: Generate contribution reports and export them as Excel or PDF files.
- **Interactive Dashboard**: Real-time dashboard for monitoring and tracking community contributions.

---

## Dashboard Preview

Here’s a preview of the application's dashboard:

![Dashboard Preview](docs-images/dashboard-preview.png)

---

## How to Run the Project

To run this project locally, follow the steps below:

1. **Start XAMPP** and ensure **Apache** and **MySQL** services are running.

2. Clone the repository and navigate to the project directory:

   ```bash
   git clone https://github.com/ikhsannovianto/Iuran-Warga-App.git
   cd Iuran-Warga-App
