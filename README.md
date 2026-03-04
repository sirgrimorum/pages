# Pages

![Latest Version on Packagist](https://img.shields.io/packagist/v/sirgrimorum/pages.svg?style=flat-square)
![PHP Version](https://img.shields.io/packagist/php-v/sirgrimorum/pages.svg?style=flat-square)
![Total Downloads](https://img.shields.io/packagist/dt/sirgrimorum/pages.svg?style=flat-square)
![License](https://img.shields.io/packagist/l/sirgrimorum/pages.svg?style=flat-square)

Database-driven page and section manager for Laravel. Define structured pages composed of independent sections, control access per page or section via policy closures, inject dynamic content from Eloquent collections, and wire everything into AutoMenu navigation — all from configuration.

## Features

- **Database-backed pages and sections** — manage content via CRUD admin (requires sirgrimorum/crudgenerator)
- **Composable sections** — pages are assembled from ordered, independently-controlled sections
- **Policy-based access control** — flexible wildcard pattern rules per page and section name
- **Special sections** — inject dynamic content (Blade templates, model collections, method results) into page content via `{%%name%%}` placeholders
- **AutoMenu integration** — automatically populate a menu with all accessible pages
- **Localized routes** — optional URL localization out of the box
- **Blade directives** — render pages and sections from any template
- **Seeder generation** — dump pages/sections to a seed file with one command

## Requirements

- PHP >= 8.2
- Laravel >= 9.0
- sirgrimorum/transarticles ^1.3
- sirgrimorum/crudgenerator ^3.8

## Installation

```bash
composer require sirgrimorum/pages
```

### Run migrations

```bash
php artisan migrate
```

Creates the `paginas` (pages) and `sections` tables.

### Publish configuration

```bash
php artisan vendor:publish --provider="Sirgrimorum\Pages\PagesServiceProvider" --tag=config
```

Publishes `config/sirgrimorum/pages.php`.

### Publish language files (optional)

```bash
php artisan vendor:publish --provider="Sirgrimorum\Pages\PagesServiceProvider" --tag=lang
```

### Publish views (optional)

```bash
php artisan vendor:publish --provider="Sirgrimorum\Pages\PagesServiceProvider" --tag=views
```

### Register CRUD configurations

```bash
php artisan pages:registercrud
```

Registers the `Pagina` and `Section` models with CrudGenerator so they can be managed via the admin interface.

## Configuration

`config/sirgrimorum/pages.php`

### Routing

```php
'with_routes' => true,   // Auto-register package routes
'localized'   => true,   // Prefix routes with locale: /{locale}/...
'group_name'  => 'paginas.',
'group_prefix' => '',    // Additional URL prefix
```

### View layout

```php
'extends' => 'layouts.app',  // Parent Blade layout
'content' => 'content',      // @section name for page content
```

### Asset injection

```php
'js_section'  => 'scripts',  // @push stack name for JS
'css_section' => 'styles',   // @push stack name for CSS
```

### Access control policies

Define access rules using name patterns. More specific patterns take precedence.

```php
'paginas_policies' => [
    '_general' => fn() => true,                         // all pages (default)
    'admin*'   => fn() => Auth::user()?->isAdmin(),     // pages starting with "admin"
    '*private' => fn() => Auth::check(),                // pages ending with "private"
    '*secret*' => fn() => false,                        // pages containing "secret"
    'dashboard' => fn() => Auth::check(),               // exact match
],
'sections_policies' => [
    '_general' => fn() => true,
],
```

Pattern matching rules (in order of precedence):
1. `pageName` — exact match
2. `*name` — ends with "name"
3. `name*` — starts with "name"
4. `*name*` — contains "name"
5. `_general` — catch-all

### Special sections

Special sections let you inject dynamic content into pages using `{%%name%%}` placeholders in page templates.

```php
'special_sections' => [
    'featured_posts' => [
        'type'      => 'collection',             // 'simple', 'collection', or 'model'
        'isModel'   => App\Models\Post::class,
        'function'  => 'getFeatured',            // Method to call on the model
        'template'  => 'partials.featured_post', // Blade template for each item
    ],
    'site_notice' => [
        'type'     => 'simple',
        'template' => 'partials.site_notice',   // Just renders a Blade view
    ],
],
```

In your page template (stored in the database):

```html
<div class="main-content">{%%content%%}</div>
<aside>{%%featured_posts%%}</aside>
<div class="notice">{%%site_notice%%}</div>
```

## Usage

### Render a page

```blade
{{-- Render the first accessible page --}}
@load_page()

{{-- Render a specific page by name --}}
@load_page('home')

{{-- Render a page with custom config --}}
@load_page('home', 'sirgrimorum/pages')
```

### Render a single section

```blade
@load_section('hero-banner')
```

### Build an AutoMenu config with pages

```php
use Sirgrimorum\Pages\Pages;

// Inject all accessible pages into position 2 of the left nav
$menuConfig = Pages::getAutoMenuConfig(2, 'izquierdo', config('sirgrimorum/menus/main'));
echo AutoMenu::buildAutoMenu('main-nav', '', $menuConfig);
```

### Check access programmatically

```php
use Sirgrimorum\Pages\Pages;

if (Pages::hasAccessToPagina($page)) {
    // user can see this page
}

if (Pages::hasAccessToSection($section)) {
    // user can see this section
}
```

## API Reference

### `Pages::buildPage()`

```php
Pages::buildPage(
    mixed  $name   = '',  // Page name, ID, object, or '' for first allowed
    mixed  $config = '',  // Config array or path
    mixed  $sections = '' // Sections array override
): string
```

Returns the rendered HTML for the page, including all its sections.

### `Pages::buildSection()`

```php
Pages::buildSection(mixed $name, mixed $config = ''): string
```

Returns the rendered HTML for a single section.

### `Pages::getFirstAllowedPage()`

```php
Pages::getFirstAllowedPage(): ?Pagina
```

Returns the first page the current user is allowed to view.

### `Pages::getAutoMenuConfig()`

```php
Pages::getAutoMenuConfig(
    int    $offset,   // Position to insert pages in the menu array
    string $lado,     // Menu side: 'izquierdo' or 'derecha'
    array  $automenu  // Existing menu structure to inject into
): array
```

### Blade directives

```blade
@load_page(string $name = '', mixed $config = '')
@load_section(string $name, mixed $config = '')
```

## Artisan Commands

| Command | Description |
|---------|-------------|
| `pages:registercrud` | Register Pagina and Section models with CrudGenerator |
| `pages:createseed` | Generate a seed file from the current pages/sections data |
| `pages:registermiddleware` | Register package middleware in the application |

## License

The MIT License (MIT). See [LICENSE.md](LICENSE.md).
