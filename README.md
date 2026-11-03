# CrudsCorte2

Aplicación Laravel para administrar insumos, proveedores, compras y movimientos de kardex.

## Requisitos

- PHP 8.3 o superior con las extensiones `pdo_sqlite`, `mbstring`, `openssl`, `fileinfo` y `dom`.
- Composer 2.
- Node.js y npm.

## Instalación en Windows

Desde la carpeta del repositorio, ejecuta en PowerShell:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
New-Item -ItemType File -Path database\database.sqlite -Force
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Abre `http://127.0.0.1:8000/register` para crear una cuenta. Las cuentas nuevas tienen permisos de consulta. Para dar permisos de administrador a una cuenta:

```powershell
php artisan tinker
```

```php
App\Models\User::where('email', 'tu-correo@example.com')->firstOrFail()->assignRole('admin');
```

No agregues `.env` al control de versiones; contiene la clave local de la aplicación.

Si ya tenías una base de datos creada y no aparecen los módulos en el panel, ejecuta:

```powershell
php artisan db:seed
```

## Pruebas

```powershell
php artisan test
```
