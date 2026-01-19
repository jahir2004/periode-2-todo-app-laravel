<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# Todo App - Leerresultaten

## Overzicht
Deze todo-app is gebouwd met Laravel en demonstreert kernconcepten zoals soft deletes, database migraties, routing, en Blade templating.

---

## Wat je hebt geleerd

### 1. **Soft Deletes** 🗑️
Soft deletes betekenen dat gegevens niet permanent uit de database worden verwijderd, maar alleen worden gemarkeerd als verwijderd met een `deleted_at` timestamp.

**Implementatie:**
- Voeg de `SoftDeletes` trait toe aan het model:
  ```php
  use Illuminate\Database\Eloquent\SoftDeletes;
  
  class Task extends Model
  {
      use SoftDeletes;
  }
  ```

- Voeg een `softDeletes()` kolom toe in de migratie:
  ```php
  Schema::table('tasks', function (Blueprint $table) {
      $table->softDeletes();
  });
  ```

**Praktisch nut:** Gebruikers kunnen fouten herstellen en je behoudt archivale data.

---

### 2. **Database Migraties**
Migraties zijn versiebeheer voor je database. Ze maken het eenvoudig om de database structuur te wijzigen en terug te draaien.

**Commando's:**
```bash
php artisan make:migration add_soft_deletes_to_tasks_table --table=tasks
php artisan migrate
php artisan migrate:rollback
```

---

### 3. **Laravel Queries & Scopes**
Je hebt geleerd hoe je queries schrijft om taken op te halen, te filteren en te verwijderen.

**Voorbeelden:**
```php
// Normale taken ophalen
Task::where('user_id', auth()->id())->get();

// Alleen verwijderde taken ophalen
Task::onlyTrashed()->where('user_id', auth()->id())->get();

// Alles ophalen (normaal + verwijderd)
Task::withTrashed()->get();

// Filteren op categorie
Task::where('category_id', $categoryId)->get();

// Verwijderde taken herstellen
Task::withTrashed()->find($id)->restore();

// Permanent verwijderen
Task::withTrashed()->find($id)->forceDelete();
```

---

### 4. **Model Traits**
Traits zijn herbruikbare blokken code die je aan models kunt toevoegen zonder overerving te gebruiken.

**Gebruikt in deze app:**
- `HasFactory` - voor test data
- `SoftDeletes` - voor soft delete functionaliteit

---

### 5. **Controller Methoden**
Controllers bevatten de logica voor het afhandelen van HTTP verzoeken.

**Belangrijke methoden:**
```php
// Alle taken ophalen met filter
public function index(Request $request)
{
    $categoryId = $request->get('category');
    $tasks = Task::where('user_id', auth()->id());
    
    if ($categoryId) {
        $tasks->where('category_id', $categoryId);
    }
    
    return view('tasks.index', [
        'tasks' => $tasks->get(),
        'categories' => Category::all(),
    ]);
}

// Prullenbak ophalen
public function trash()
{
    $tasks = Task::onlyTrashed()->where('user_id', auth()->id())->get();
    return view('tasks.trash', compact('tasks'));
}

// Taak herstellen
public function restore($id)
{
    Task::withTrashed()->find($id)->restore();
    return redirect()->route('tasks.trash')->with('success', 'Taak hersteld!');
}

// Taak verwijderen (soft delete)
public function destroy(Task $task)
{
    $task->delete();
    return redirect()->back()->with('success', 'Taak verwijderd!');
}
```

---

### 6. **Routing**
Routes verbinden URLs met controller methoden.

**Routes in deze app:**
```php
Route::middleware('auth')->group(function () {
    // Normale taken
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    
    // Prullenbak
    Route::get('/tasks/trash', [TaskController::class, 'trash'])->name('tasks.trash');
    Route::post('/tasks/restore/{id}', [TaskController::class, 'restore'])->name('tasks.restore');
    
    // Verwijderen
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});
```

**Route Parameters:**
- `:name` - haalt parameters uit de URL
- `->name()` - geeft een naam voor `route()` helpers

---

### 7. **Blade Templating**
Blade is Laravel's template engine met speciale PHP syntax.

**Basis Blade syntaxis:**
```blade
{{-- Dit is een comment --}}

{{-- Variabele weergeven --}}
<h1>{{ $task->title }}</h1>

{{-- If statements --}}
@if ($tasks->count())
    <p>Je hebt taken</p>
@else
    <p>Geen taken</p>
@endif

{{-- Loops --}}
@foreach ($tasks as $task)
    <div>{{ $task->title }}</div>
@endforeach

{{-- Csrf token (essentieel voor formulieren) --}}
<form method="POST" action="{{ route('tasks.store') }}">
    @csrf
    <input type="text" name="title">
</form>
```

---

### 8. **Debugging met Tinker**
Tinker is een REPL (Read-Eval-Print Loop) tool voor het testen van code.

**Commando's:**
```bash
php artisan tinker

# Importeer de Task class
use App\Models\Task;

# Controleer verwijderde taken
Task::onlyTrashed()->get();

# Herstellen via Tinker
Task::withTrashed()->find(77)->restore();

# Permanent verwijderen
Task::withTrashed()->find(77)->forceDelete();
```

---

### 9. **Authentication & Authorization**
Je hebt geleerd hoe je gebruikers authenticeren en hun taken isoleren.

```php
// Huidige gebruiker ophalen
auth()->user()
auth()->id()

// In queries
Task::where('user_id', auth()->id())->get();

// Middleware
Route::middleware('auth')->group(function () {
    // Routes hier zijn beveiligd
});
```

---

### 10. **Formulieren & Request Handling**
Je hebt geleerd hoe je formulieren verwerkt en data valideert.

```blade
{{-- Verwijderformulier --}}
<form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Verwijderen</button>
</form>

{{-- Herstelformulier --}}
<form action="{{ route('tasks.restore', $task->id) }}" method="POST">
    @csrf
    <button type="submit">Herstellen</button>
</form>
```

---

## Functionaliteiten in deze app

### ✅ Taken beheren
- Alle taken weergeven
- Taken filteren op categorie
- Status wijzigen (todo, in_progress, done)

### ✅ Soft Deletes
- Taken verwijderen (soft delete)
- Prullenbak pagina
- Verwijderde taken herstellen

### ✅ User Isolation
- Elke gebruiker ziet alleen zijn eigen taken
- Beveiliging via `auth()->id()`

---

## Belangrijke Commands

```bash
# Laravel starten
php artisan serve

# Database migreren
php artisan migrate

# Cache wissen
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Tinker starten
php artisan tinker

# Database herstellen
php artisan migrate:fresh
php artisan migrate:fresh --seed
```

---

## Structuur van de App

```
todo-app2/
├── app/
│   ├── Http/Controllers/TaskController.php
│   └── Models/Task.php
├── database/
│   ├── migrations/
│   └── seeders/TaskSeeder.php
├── resources/
│   └── views/tasks/
│       ├── index.blade.php
│       └── trash.blade.php
├── routes/
│   └── web.php
└── README.md
```

---

## Leermoment: Soft Deletes in actie

### Scenario 1: Gebruiker verwijdert een taak
```
1. Gebruiker klikt op "Verwijderen"
2. POST verzoek naar /tasks/{id}
3. Controller voert $task->delete() uit
4. Task.deleted_at wordt ingesteld op huiig moment
5. Taak verdwijnt van takenpagina
6. Taak verschijnt op prullenbak pagina
```

### Scenario 2: Gebruiker herstelt een taak
```
1. Gebruiker klikt op "Herstellen" in prullenbak
2. POST verzoek naar /tasks/{id}/restore
3. Controller voert $task->restore() uit
4. Task.deleted_at wordt gezet op NULL
5. Taak verdwijnt van prullenbak
6. Taak verschijnt terug op takenpagina
```

---

## Dingen om te onthouden

1. **Soft Deletes** beschermen je gegevens
2. **Migraties** zijn essentieel voor database versiebeheer
3. **Routes** verbinden URLs met controllers
4. **Blade** maakt templates makkelijk
5. **Auth** isoleert gebruiker's data
6. **Tinker** helpt bij debugging

---

## Volgende stappen om verder te leren

1. Voeg **permanent verwijderen** toe (forceDelete)
2. Maak een **recovery pagina** met verwijderingsdatum
3. Voeg **bulk restore** toe voor meerdere taken
4. Implementeer **soft delete policies** voor beveiliging
5. Voeg **undo functionaliteit** toe

---

**Opgesteld op:** 19 januari 2026  
**Versie:** 1.0  
**Status:** ✅ Soft Deletes Werkend
