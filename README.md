1. Clone the Repository
git clone https://github.com/rohitjangir681/url-shortener.git
cd url-shortener

2. Install Dependencies
composer install
npm install && npm run dev

3. Create .env File
cp .env.example .env


Then edit the .env file and set up your database (e.g., for XAMPP):
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=

4. Generate App Key
php artisan key:generate


5. Run Migrations
php artisan migrate

6. Seed SuperAdmin Account
php artisan db:seed

This creates a SuperAdmin:
Email: superadmin@example.com
Password: password


7. Start Local Server
php artisan serve


Visit: http://127.0.0.1:8000/


Mail Configuration (Mailtrap)
This project uses Mailtrap for email testing (used for sending user invitations).

