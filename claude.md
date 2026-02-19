# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Hero Draft is a web application for generating superhero cards using AI image generation APIs (Stability AI). Built with Laravel 12 + Vue 3 + TypeScript using Inertia.js for seamless SSR.

## Development Commands

### Full Development Stack
```bash
composer dev          # Starts server, queue, logs, and Vite concurrently
composer dev:ssr      # SSR development mode
```

### Running Tests
```bash
composer test         # Full test suite (clears config, lint check, PHPUnit)
php artisan test      # PHPUnit only
php artisan test --filter=TestName  # Run specific test
```

## Code Quality

### PHP
```bash
composer lint         # Fix PHP code style with Pint
composer test:lint    # Check PHP code style
```

### JavaScript/TypeScript
```bash
npm run lint          # ESLint fix
npm run format        # Prettier format
npm run format:check  # Check formatting
```

### Building
```bash
npm run build         # Production build
npm run build:ssr     # SSR production build
```

### Setup (Fresh Install)
```bash
composer setup        # Full setup: install deps, env, migrate, build
```

## Architecture

### Stack
- Backend: Laravel 12 with Fortify authentication (includes 2FA)
- Frontend: Vue 3 with Inertia.js for SSR
- Styling: Tailwind CSS v4 with Reka UI component library
- Build: Vite with hot module reloading

### Key Directories
- `app/Http/Controllers/` - Route controllers
- `app/Http/Controllers/Settings/` - User settings endpoints
- `resources/js/pages/` - Inertia page components
- `resources/js/components/` - Reusable Vue components
- `resources/js/layouts/` - Page layouts (AppLayout, AuthLayout, SettingsLayout)
- `resources/js/composables/` - Vue composables
- `routes/web.php` - Main routes
- `routes/settings.php` - Settings routes

### Entry Points
- Client: `resources/js/app.ts`
- Server (SSR): `resources/js/ssr.ts`
- Styles: `resources/css/app.css`

### Database
Default SQLite for development. Migrations in `database/migrations/`.

## Code Style
- PHP: Laravel Pint with Laravel preset
- TypeScript/Vue: ESLint + Prettier (2-space indentation, single quotes, no semicolons)
- Path alias: `@/` maps to `resources/js/`
