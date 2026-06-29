📦 CARA INSTALL PROJECT GEAR-RENTAL

1. Extract ZIP ke C:\laragon\www\gear-rental atau clone jika menggunakan github

2. Buka Terminal Laragon, lalu:
   cd C:\laragon\www\gear-rental

3. Install vendor:
   composer install

4. Buat .env dari .env.example:
   copy .env.example .env

5. Generate key:
   php artisan key:generate

6. Buat database di phpMyAdmin (nama: pendakian_db)

7. Edit .env, sesuaikan database:
   DB_DATABASE=pendakian_db
   DB_USERNAME=root
   DB_PASSWORD=

8. Jalankan migration:
   php artisan migrate:fresh --seed

9. Link storage:
   php artisan storage:link

10. php artisan tinker
# Ketik di tinker:
User::create(['username' => 'admin', 'password' => Hash::make('password'), 'full_name' => 'Administrator', 'role' => 'admin']);

11. Jalankan server:
    php artisan serve

12. Buka browser: http://localhost:8000

🔑 Login: driyan90 / password

⚠️ Error? Jalankan:
composer dump-autoload
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear