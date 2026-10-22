# VPay property management

PHP/MySQL application for properties, units, tenant assignments, invoices and payments.

## Run locally

Requirements: PHP 8.1+ with mysqli and OpenSSL, MySQL/MariaDB, Node.js 20+ and npm.

The existing application database is required; this repository does not contain a complete initial schema or seed users. Configure `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` and `DB_PASSWORD` in your web server environment. Existing local connection defaults remain supported.

For an existing database, apply `database/001_settings.sql` once to add the settings table. It preserves existing records.

```sh
npm install --include=optional
npm run build
php -S localhost:8080
```

Open `http://localhost:8080/index.php`. Navigation uses explicit PHP paths, so Apache URL rewriting is optional.

## Verify changes

```sh
npm run check
npm run build
npm run test:smoke
npm run test:integration
```

The smoke check reads the configured database, selects an existing user for page rendering, and checks all 15 main pages for PHP errors. It does not create payments or alter business records. The integration check requires Python 3, permission to create a temporary MySQL database, and permission to bind a local HTTP port. It clones table definitions, exercises payment settlement, duplicate protection, CSRF, tenant assignments and settings using synthetic data, then deletes the temporary database. Browser interaction should also be tested before deployment.

## Payment behavior

Select a tenant, then an unpaid invoice. Property, unit, amount and billing month come from the invoice. Saving records the full invoice payment and marks the invoice paid in one transaction. An invoice row lock prevents concurrent duplicate settlement. Partial payments are not supported. Legacy invoices store property and unit names; ambiguous or missing matches are rejected rather than recording against the wrong property. Historical payments are preserved without automatic reconciliation to invoices.

Settings are saved as metadata. Currency, paybill, late fees and due days are administrative values; payment amounts remain in KES, and no automatic late-fee calculation or M-Pesa API integration is provided.

Existing encrypted passwords remain accepted for compatibility. Password changes in Settings store a password hash. Authenticated pages and endpoints require a session; POST requests also require a CSRF token.

CSS is compiled locally. jQuery, Select2, datepicker, notifications and table export libraries currently load from CDNs and require internet access in the browser.

## Theme and local assets

Tailwind CSS v4 compiles `src/input.css` into `src/output.css`. No Tailwind browser script or CSS CDN is used. Run `npm run dev` while editing PHP templates or the theme, and `npm run build` for a minified stylesheet. PHP asset versioning refreshes the stylesheet after each build.

The shared theme uses navy, ivory and emerald with responsive navigation, consistent form controls, local Font Awesome assets, and the original architectural SVG at `src/img/architecture.svg`. Typography uses the operating system font stack; no font download is required. The login page works without external JavaScript. Other pages still use CDN-hosted jQuery and its existing UI plugins.

Dashboard charts show recorded payment dates over the last six months; summary cards retain the existing billing-month calculations. Empty states never fabricate collections or growth figures.
