# E-Barangay Information and Management System

A web-based system developed to help barangay staff manage resident records, household information, certificate requests, blotter cases, and other barangay-related transactions. It provides a centralized platform for handling records, processing requests, and generating reports.

## Technology Stack

Backend: Laravel 12, PHP 8.2+

Database: MySQL-compatible database, Laravel Migrations, and Eloquent ORM

Frontend: Blade, Bootstrap, JavaScript, and Vite

PDF Generation: DomPDF

Testing: PHPUnit and Laravel Feature Tests

## Features

### Role-Based Access Control
- Implements five user roles: `admin`, `subadmin`, `resident`, `non-resident`, and `superadmin`.
- Uses authentication and role middleware to restrict access to specific pages and functions.
- Tracks user activities, including administrative actions and visits to different modules.

### Resident and Household Management
- Manages resident profiles, household members, family relationships, houses, streets, and household heads.
- Supports resident registration, profile editing, household assignment, and archiving.
- Uses Eloquent relationships to connect residents, users, households, houses, and streets.

### Barangay Services
- Includes certificate requests, complaints, blotter cases, service requests, feedback, and announcements.
- Allows barangay staff to review, approve, reject, update, and archive submitted records.
- Provides separate interfaces and workflows for residents, administrators, and subadministrators.

### Reports and PDF Generation
- Includes 10 report categories: population, blotter, certificate, household, complaint, activity, officials, archives, announcements, and feedback.
- Supports filtering reports by date, status, demographics, household information, and other module-specific fields.
- Generates printable reports and PDF documents using DomPDF.
- Saves report records and filters so previously generated reports can be viewed and printed again.

### Administrative Management
- Maintains activity logs, generated reports, archived records, barangay officials, official histories, system settings, and announcements.
- Provides searchable and filterable pages for managing barangay records and monitoring activities.

## Project Scope

- 23 database tables created through Laravel migrations for users, residents, households, houses, blotter cases, certificate requests, activity logs, reports, and other records.
- 37 backend routes covering resident, household, blotter, and certificate-related operations.
- 13 report routes protected by authentication, `role:admin` middleware, and module activity logging.
- 10 report generation endpoints for generating filtered administrative reports.

## Local Development

### 1. Install PHP dependencies

```bash
composer install
```

### 2. Set up the environment

```bash
copy .env.example .env
php artisan key:generate
```

### 3. Configure the database

Update the database settings in `.env`, then run:

```bash
php artisan migrate
```

### 4. Install frontend dependencies

```bash
npm install
npm run build
```

### 5. Start