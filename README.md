# mmoollllee/filament-cms-core

The content engine of [`mmoollllee/filament-cms`](https://github.com/mmoollllee/filament-cms):
content types (blueprints), hierarchical paths and publishing windows, the block builder
(inline preview editing, copy/paste, drag & drop across sections, layout presets), the
RichEditor stack (link picker, HTML preservation, merge tags, media picker), drafts and
preview, versions, editorial locking, fragments and the media integration.

- **Namespace:** `Mmoollllee\Cms\` — shared with the site layer, so code written against
  filament-cms keeps working unchanged.
- **Provider:** `Mmoollllee\Cms\CmsCoreServiceProvider`, auto-discovered.

## Who uses it

- **Sites on filament-cms** get it through that package, which adds the site layer:
  tenant-by-host, memberships and invitations, the admin panel, redirects and 404
  handling, menus, the site shell and its views. Nothing to do here.
- **Apps with their own tenancy and panels** require this package alone. Embedding
  without the site layer is still being made clean (plugin, tenant and URL hooks,
  abilities instead of roles) — see the roadmap in nest.kuckuck.cam,
  `docs/roadmap/filament-cms-core.md`.

## Installation

```jsonc
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/mmoollllee/filament-cms-core" },
        { "type": "composer", "url": "https://packages.filamentphp.com/composer" },
        { "type": "vcs", "url": "https://github.com/mmoollllee/filament-builder-title" },
        { "type": "vcs", "url": "https://github.com/mmoollllee/filament-tenant-access" }
    ],
    "require": {
        "mmoollllee/filament-cms-core": "^0.24"
    }
}
```

Composer reads repositories from the ROOT composer.json only, so every app declares the
ones the engine's own dependencies need. `awcodes/richer-editor` comes from Filament's
plugin registry and needs an `auth.json` with filamentphp.com credentials.

The schema ships publish-only: `php artisan vendor:publish --tag=cms-migrations`.

## Assets

`php artisan filament:assets` publishes the builder styles and the TipTap extensions.
The TipTap extensions are pre-built into `resources/dist` (`npm run build`).
