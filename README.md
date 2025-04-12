
# Educare - School Management System

![Educare Logo](https://via.placeholder.com/150x50?text=Educare)

## Overview

Educare is a comprehensive school management system built with Laravel. It streamlines administrative processes, enhances communication between stakeholders, and provides a centralized platform for managing educational institutions.

## Features

### User Roles and Access Management
- **Admin Panel**: Complete control over system configuration, user management, and institutional settings
- **Staff Portal**: Manage classes, assignments, grades, attendance, and communicate with students and parents
- **Student Dashboard**: Access to coursework, grades, schedules, and communication tools
- **Parent Portal**: Monitor children's academic progress, attendance, and communicate with teachers

### Core Functionalities
- **Student Management**: Enrollment, profiles, academic records, and attendance tracking
- **Staff Management**: HR functions, teaching assignments, and performance tracking
- **Academic Management**: Courses, classes, timetables, and curriculum planning
- **Attendance System**: Digital tracking for students and staff
- **Gradebook**: Comprehensive grading system with customizable assessment criteria
- **Communication Hub**: Messaging system, announcements, and notifications
- **Reports Generation**: Academic reports, attendance summaries, and institutional analytics
- **Financial Management**: Fee tracking, payment processing, and financial reporting

## Technology Stack

- **Backend**: Laravel 12
- **Frontend**: Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel's built-in authentication
- **Task Queue**: Laravel Queue
- **Development Tools**: Vite, Laravel Sail

## Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL or PostgreSQL

### Installation Steps

1. Clone the repository
   ```bash
   git clone https://github.com/yourusername/educare.git
   cd educare
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install JavaScript dependencies
   ```bash
   npm install
   ```

4. Copy the environment file and configure it
   ```bash
   cp .env.example .env
   ```

5. Generate application key
   ```bash
   php artisan key:generate
   ```

6. Configure the database in `.env` file
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=educare
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Run migrations and seeders
   ```bash
   php artisan migrate --seed
   ```

8. Build assets
   ```bash
   npm run build
   ```

9. Start the development server
   ```bash
   php artisan serve
   ```

   Or use the convenience script for full development environment
   ```bash
   composer run dev
   ```

## Development

### Useful Commands

- Run development server with hot reloading
  ```bash
  composer run dev
  ```

- Run tests
  ```bash
  php artisan test
  ```

- Format code using Laravel Pint
  ```bash
  ./vendor/bin/pint
  ```

## Deployment

### Requirements
- Web server (Nginx or Apache)
- PHP >= 8.2
- MySQL or PostgreSQL
- Composer
- Node.js & NPM

### Deployment Steps
1. Set up a production environment on your server
2. Clone the repository to your server
3. Install dependencies (composer install --no-dev)
4. Configure your .env file for production
5. Build assets for production (npm run build)
6. Configure your web server to point to the public directory
7. Set appropriate file permissions
8. Set up a scheduler for Laravel's scheduled tasks

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact

Project Link: [https://github.com/latimax/educare](https://github.com/latimax/educare)

---

Made with ❤️ by Latimax & Wisdom
