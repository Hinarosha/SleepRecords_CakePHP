# Sleep Tracking Application (SleepRecords)

## Overview
This web application helps users track and manage their sleep patterns. Users can record their sleep times, wake times, energy levels, naps, and monitor their sleep quality over time. The application provides insights into sleep habits, calculates sleep cycles, and helps maintain a healthy sleep schedule.

## Features
- User registration and authentication with permission-based access control
- Record sleep and wake times with energy level tracking
- Track sleep cycles (1.5-hour cycles) and sleep duration
- Record afternoon and evening naps
- Track sport/exercise activities
- View sleep history and statistics
- Weekly and global sleep statistics
- Admin panel for user and menu management
- Dynamic menu system with permission-based visibility

## Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Git

### Installation Steps

1. Clone the repository
```bash
git clone [your-repository-url]
cd [project-directory]
```

2. Install dependencies
```bash
composer install
```

3. Configure your database
- Copy `config/.env.example` to `config/.env`
- Update the database configuration in `config/.env`:
```env
DATABASE_URL="mysql://username:password@localhost:3306/sleep_records"
# OR use individual variables:
DB_USERNAME="your_username"
DB_PASSWORD="your_password"
DB_DATABASE="sleep_records"
```

4. Set up the database
- Create a new MySQL database:
```sql
CREATE DATABASE sleep_records CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
- Run CakePHP migrations to create all tables and seed initial data:
```bash
bin/cake migrations migrate
```
This will create:
  - `users` table (with permission levels)
  - `sleep_records` table (with all sleep tracking fields)
  - `menus` table (with permission-based visibility)
  - Seed initial menu items

5. Start the development server
```bash 
bin/cake server
```

The application should now be running at http://localhost:8765

## Project Structure and Key Components

### Controllers
- SleepRecordsController.php: 
  - Located in src/Controller/
  - Handles CRUD operations for sleep records
  - Manages sleep record validation
  - Processes sleep statistics

### Models
- SleepRecord.php:
  - Located in src/Model/Table/
  - Defines relationships and validation rules
  - Contains methods for calculating sleep metrics

### Templates
- templates/SleepRecords/:
  - index.php: Displays list of sleep records
  - add.php: Form for adding new sleep records
  - edit.php: Form for modifying existing records
  - view.php: Detailed view of a single record

### Database Schema
The application uses three main tables:

1. **users**
   - `id`: Primary key
   - `username`: Unique username
   - `email`: Unique email address
   - `password`: Hashed password (bcrypt)
   - `firstname`: User's first name
   - `lastname`: User's last name
   - `permission`: Permission level (0 = normal user, 1 = reserved, 2 = admin)
   - `created`: Account creation timestamp
   - `modified`: Last modification timestamp

2. **sleep_records**
   - `id`: Primary key
   - `user_id`: Foreign key to users table (CASCADE delete)
   - `date`: Date of the sleep record
   - `bedtime`: Time when user went to bed
   - `waketime`: Time when user woke up
   - `afternoon_nap`: Boolean flag for afternoon nap
   - `evening_nap`: Boolean flag for evening nap
   - `energy_level`: Energy level (0-10 scale)
   - `sport`: Boolean flag for exercise/sport activity
   - `comments`: Additional notes (text)
   - `created`: Record creation timestamp
   - `modified`: Last modification timestamp

3. **menus**
   - `id`: Primary key
   - `ordre`: Display order (integer)
   - `intitule`: Menu item title
   - `lien`: URL link/path
   - `required_permission`: Minimum permission level needed to see this menu (0-2)
   - `created`: Record creation timestamp
   - `modified`: Last modification timestamp

### Permission System
The application uses a simple permission-based access control:
- **Level 0**: Normal users (default for new registrations)
  - Can manage their own sleep records
  - Can access their personal admin page
- **Level 1**: Reserved for future use (currently same as level 0)
- **Level 2**: Administrators
  - Can manage all users (view list, change permissions)
  - Can manage menu items
  - Can access all admin features

Menu visibility is controlled by the `required_permission` field in the `menus` table. Only users with permission level >= `required_permission` will see that menu item.

## Usage Guide

### First-Time Setup
After running migrations, you'll need to create an admin user. You can either:
1. Register a new user through `/register` (will be permission level 0)
2. Manually update a user's permission to 2 in the database:
```sql
UPDATE users SET permission = 2 WHERE email = 'admin@example.com';
```

### Recording Sleep
1. Log in to your account
2. Navigate to "Mes enregistrements" (My Records)
3. Click "Add Sleep Record" button
4. Enter:
   - Date of sleep
   - Bedtime and wake time
   - Energy level (0-10)
   - Optional: afternoon nap, evening nap, sport activity, comments
5. Submit the form

### Viewing Statistics
1. Navigate to "Mes enregistrements"
2. View your sleep records in chronological order
3. Statistics include:
   - Sleep cycles (calculated automatically: 1 cycle = 1.5 hours)
   - Sleep hours
   - Weekly statistics (total cycles, consecutive days, average energy)
   - Global statistics (average cycles, best streak, sport percentage)

### Admin Features (Permission Level 2)
- **User Management** (`/users`): View all users, change their permission levels
- **Menu Management** (`/menus`): Add, edit, delete, and reorder menu items
  - Set `required_permission` for each menu item to control visibility

## Common Issues & Troubleshooting

### Database Connection Issues
- Verify database credentials in your `.env` file
- Make sure your `.env` file is properly loaded (check if debug messages show DATABASE_* variables are set)
- Ensure MySQL service is running
- Check if the database exists and is accessible

### Permission Issues
For Linux:
```bash
chmod -R 777 tmp/
chmod -R 777 logs/
```

For Windows:
- Right-click on the tmp/ and logs/ folders
- Properties -> Security -> Edit
- Give full control to the user running the web server
- Apply and OK

### Installation Problems
- Clear cache after configuration changes:
```bash
bin/cake cache clear_all
```

- If composer shows errors, try:
```bash
composer update --no-scripts
composer dump-autoload
```

### Common Runtime Errors
1. "Database connection failed"
   - Check credentials in .env file
   - Verify MySQL is running
   - Ensure database exists

2. "Permission denied"
   - Check file permissions
   - Verify web server user permissions

3. "Class not found"
   - Run composer dump-autoload
   - Clear CakePHP cache

## Development Guidelines

### Coding Standards
- Follow PSR-12 coding standards
- Use CakePHP coding conventions
- Document all methods and classes
- Write unit tests for new features

### Git Workflow
1. Create feature branch from main
2. Make changes and test
3. Submit pull request
4. Wait for review and approval

### Testing
Run tests using:
```bash
vendor/bin/phpunit
```

## Contributing
1. Fork the repository
2. Create your feature branch (git checkout -b feature/AmazingFeature)
3. Commit your changes (git commit -m 'Add some AmazingFeature')
4. Push to the branch (git push origin feature/AmazingFeature)
5. Open a Pull Request

## Production Deployment

### Prerequisites
- PHP 8.1+ with required extensions
- MySQL/MariaDB 5.7+
- Composer
- Web server (Apache/Nginx)

### Deployment Steps

1. **Clone and install dependencies:**
```bash
git clone [your-repository-url]
cd [project-directory]
composer install --no-dev --optimize-autoloader
```

2. **Configure environment:**
```bash
cp config/.env.example config/.env
# Edit config/.env with production database credentials
# Set DEBUG=false or equivalent in your environment
```

3. **Set up database:**
```bash
# Create database
mysql -u root -p
CREATE DATABASE sleep_records CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Run migrations
bin/cake migrations migrate
```

4. **Configure web server:**

**Nginx example:**
```nginx
server {
    server_name yourdomain.com;
    root /var/www/sleeprecords/webroot;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

**Apache example:**
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/sleeprecords/webroot

    <Directory /var/www/sleeprecords/webroot>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

5. **Set file permissions:**
```bash
chown -R www-data:www-data tmp logs
chmod -R 775 tmp logs
```

6. **Clear and warm caches:**
```bash
bin/cake cache clear_all
bin/cake schema_cache build
```

7. **Set up HTTPS** (recommended):
- Use Let's Encrypt/Certbot
- Configure SSL certificates
- Redirect HTTP to HTTPS

## Security
- All passwords are hashed using CakePHP's DefaultPasswordHasher (bcrypt)
- SQL injection prevention through CakePHP ORM
- XSS protection via CakePHP form helper and output escaping
- CSRF protection enabled by default
- Permission-based access control for admin features
- Authentication middleware protects all routes except public pages

## License
This project is licensed under the MIT License - see the LICENSE file for details.

## Support
For support, please:
1. Check the documentation
2. Search existing issues
3. Create a new issue if needed
4. Contact the maintainers

## Database Migrations

The application uses CakePHP migrations for database schema management. All migrations are located in `config/Migrations/`:

- `20260212100000_CreateUsers.php` - Creates users table
- `20260212101000_CreateSleepRecords.php` - Creates sleep_records table with foreign key
- `20260212102000_CreateMenus.php` - Creates menus table with permission system
- `20260212103000_SeedMenus.php` - Seeds initial menu items

To run migrations:
```bash
bin/cake migrations migrate
```

To rollback:
```bash
bin/cake migrations rollback
```

## Acknowledgments
- Built with CakePHP 5.x framework
- Uses CakePHP Authentication plugin
- Menu system with permission-based visibility
