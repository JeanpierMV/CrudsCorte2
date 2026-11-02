# Integrante 1 – CRUD de Insumos

Archivos nuevos (no pisan nada del repo):
- `app/Models/Insumo.php`, `app/Http/Requests/InsumoRequest.php`
- `app/Http/Controllers/InsumoController.php` y `InsumoPdfController.php`
- `database/migrations/2026_11_03_000001_create_insumos_table.php`
- `database/factories/InsumoFactory.php`
- `database/seeders/InsumoPermisosSeeder.php` y `InsumoSeeder.php`
- `routes/insumos.php`
- `resources/views/insumos/` (index, create, edit, show, _form, pdf)
- `tests/Feature/InsumoControllerTest.php`

## 1. Copiar al proyecto
```bash
git clone https://github.com/AnyeloChitan/crudEjemplo.git      # si aún no lo tienes
cd crudEjemplo
git pull origin main
git checkout -b feature/crud-insumos
# copia el CONTENIDO de esta carpeta dentro del proyecto (respeta las rutas)
```

## 2. Tres cambios pequeños en archivos existentes
**a) `routes/web.php`** – dentro del grupo con middleware `auth` (si no existe, créalo):
```php
Route::middleware('auth')->group(function () {
    // ... rutas que ya tienes ...
    require __DIR__.'/insumos.php';
});
```
**b) `database/seeders/DatabaseSeeder.php`** – dentro de `run()`, DESPUÉS de `RoleSeeder`:
```php
$this->call([
    InsumoPermisosSeeder::class,
    InsumoSeeder::class,
]);
```
**c) Menú lateral** (tu `layouts/plantilla.blade.php`):
```blade
@can('insumos.ver')
    <a href="{{ route('insumos.index') }}">Insumos</a>
@endcan
```

## 3. Probar
```bash
composer dump-autoload
php artisan migrate
php artisan db:seed --class=InsumoPermisosSeeder
php artisan db:seed --class=InsumoSeeder
php artisan test --filter InsumoControllerTest
php artisan serve
```
Para entrar como administrador asígnale el rol a tu usuario:
`php artisan tinker` → `User::first()->assignRole('admin');`

## 4. Subir
```bash
git status                      # confirma que NO aparece .env
git add app database routes resources tests
git commit -m "Agrega CRUD de insumos con autorización, filtros, paginación y PDF"
git push -u origin feature/crud-insumos
```
Después abre un Pull Request hacia `main` en GitHub.
