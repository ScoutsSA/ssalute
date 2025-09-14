# Ssalute — Scouts South Africa Member Management System

[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2F82acbd78-6c12-4233-8ecb-b532c3256ff8&style=plastic)](https://forge.laravel.com/john-roux/scouts-digital/2850417)

Ssalute is the new, modern member management system (MMS) being built by Scouts South Africa to progressively replace the legacy “Scouts Digital” platform. The goal is a secure, fast, and accessible system that the movement fully owns and can evolve.

Ssalute is open source and MIT-licensed. Contributions are welcome!

We are heavily utilizing Laravel and Filament.

## Contents
- About the project
- Tech stack
- Requirements
- Getting started (local development)
- Testing
- Coding standards
- Contributing
- Security vulnerabilities
- License
- Community & support


## About the project
We are rolling Ssalute out in phased modules over the next few years. During this migration, parts of the existing system will remain active while features and data are moved across. You can see the public “welcome” page in `resources/views/welcome.blade.php` for the latest messaging and links.

If you’d like to help, pick an issue and open a PR — we’re friendly and happy to guide first-time contributors.


## Tech stack
- Laravel 12 (PHP 8.4)
- Filament v4 (admin panel, tables, actions, forms)
- Livewire v3
- Tailwind CSS v4
- PHPUnit v11
- Vite (frontend bundling)

Check `composer.json` and `package.json` for exact versions.


## Requirements
- PHP 8.4+
- Composer 2.7+
- Node.js 20+ and npm 10+
- Mysql 8.0+ 


## Getting started (local development)
Stock Standard Laravel app
Personally we recommend PHPStorm + Valet for a native setup that closest matches production.
But head over to laravel.com/docs/12.x for more info
The "easiest" option is generally to use laravel's built in `serve` command.

```
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run dev
php artisan serve
```

## Testing
- Run all tests: php artisan test
- Filter a test: php artisan test --filter=SomeTestName

Please add tests for new features where practical. Prefer Feature tests for UI flows (Filament/Livewire) and Unit tests for isolated logic.


## Coding standards
- Run Duster to format changed files: ./vendor/bin/duster fix --dirty
- Follow existing conventions in sibling files (naming, structure, form requests, policies)
- Prefer Eloquent models and relationships over raw queries
- Add PHP return types and parameter types; use constructor property promotion


## Contributing
We welcome contributions from developers, designers, testers, and documentation writers.

How to contribute
- Pick an issue (good first issues are labeled when available)
- Create a feature branch from main
- Keep PRs focused and small when possible
- Add tests and update docs when needed
- If you'd like a sanitized testing database, please reach out directly

Local collaboration
- Join our community chat: https://chat.whatsapp.com/HkGHDBHyVap6yC8gGLXCHC
- Share ideas and proposals via GitHub Issues/Discussions


## Security vulnerabilities
If you believe you have found a security vulnerability, please do not open a public issue. Email our National IT Chair: John Roux at john.roux@scouts.org.za. We will investigate promptly and coordinate a fix and disclosure if necessary.


## License
This project is open-sourced software licensed under the MIT License. See the LICENSE file if present, or the standard MIT terms at https://opensource.org/licenses/MIT.


## Community & support
- Public site landing content: resources/views/welcome.blade.php
- WhatsApp community: https://chat.whatsapp.com/HkGHDBHyVap6yC8gGLXCHC
- Donate to Scouts South Africa: https://www.scoutfoundation.org.za/donate/#monthly-donation-options
