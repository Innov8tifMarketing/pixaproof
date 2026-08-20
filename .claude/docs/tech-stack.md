# PixaProof Marketing Site - Tech Stack

## Core Framework
| Component | Version | Notes |
|-----------|---------|-------|
| Laravel | 13.x | PHP framework |
| PHP | 8.4+ | Runtime version |
| Livewire | 3.x | Reactive components |
| Alpine.js | 3.x | Lightweight JS framework (bundled with Livewire) |

## Frontend
| Component | Version | Notes |
|-----------|---------|-------|
| Tailwind CSS | 4.x | CSS-first configuration via `@theme` directive |
| Vite | 7.x | Build tool |
| devices.css | — | Device mockup CSS framework |
| @tailwindcss/forms | — | Form styling plugin |
| @tailwindcss/typography | — | Prose styling plugin |
| blade-ui-kit/blade-heroicons | 2.6 | Heroicon SVG components |

## Database
| Component | Status | Notes |
|-----------|--------|-------|
| SQLite | Active | Development and production |

## Development Tools
| Tool | Purpose |
|------|---------|
| Laravel Pint | Code formatting |
| Laravel Pail | Log viewer |
| Laravel Sail | Docker development |
| PHPUnit | Testing (v12) |

## Deployment
| Platform | Config |
|----------|--------|
| Coolify | `nixpacks.toml` |

## Key Dependencies
```json
{
  "laravel/framework": "^13.0",
  "laravel/tinker": "^3.0",
  "livewire/livewire": "^3.7",
  "blade-ui-kit/blade-heroicons": "^2.6"
}
```

## NPM Scripts
```bash
composer dev      # Run all dev services concurrently
composer setup    # Initial project setup
composer test     # Run tests
npm run dev       # Vite dev server
npm run build     # Production build
```

---
*Updated: 2026-08-20 - Upgraded to Laravel 13 / PHPUnit 12 / Tinker 3; dropped the laravel-frontend-presets/tall scaffolding preset (no Laravel 13 release, unused at runtime)*
