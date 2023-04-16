## Cara run



#### 1. buka cmd di direktori ini


#### 2. Install composer dependencies
```console
composer install
```

#### 3. Copy file .env.example dan kasih nama .env
Buat terlebih dahulu database dengan nama siiku

```console
cp .env.example .env
```

Kalau gak bisa pake perintah _cp_, copas manual aja file **.env.example**-nya kemudian kasih nama **.env** 

Edit konfigurasi di **.env** yang udah dibuat:
```yaml
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siiku
```

In the example above we create a database called coblos which runs on Localhost (127.0.0.1) port 3306

#### 4. Generate secret key buat laravel
```console
php artisan key:generate
```

#### 5. Jalankan migrasi database
```console
php artisan migrate:fresh --seed
```

or (optional)

```console
php artisan migrate
```

#### 6. Jalankan Laravel
```console
php artisan serve
```
Akses di 127.0.0.1:8000


