<?php

// The content engine's settings (filament-cms-core), all env-driven. Merged
// into the `cms` config key next to the site layer's own (config/cms.php of
// mmoollllee/filament-cms); an app's published config/cms.php overrides both.

return [

    /*
    |--------------------------------------------------------------------------
    | Versioning (HasVersions)
    |--------------------------------------------------------------------------
    | keep   snapshot versions kept per record (older ones are pruned and
    |        force-deleted on each new version). 0 = unlimited — mind that a
    |        SNAPSHOT stores the full blocks/payload JSON per applied save.
    */
    'versions' => [
        'keep' => (int) env('CMS_VERSIONS_KEEP', 50),
    ],

    /*
    |--------------------------------------------------------------------------
    | Editorial locking (HasLocks)
    |--------------------------------------------------------------------------
    | timeout  seconds a lock survives without a presence heartbeat. Sized
    |          against the panel's 30s heartbeat (BasePanelProvider's
    |          presencePollingInterval), NOT against how long someone
    |          edits — a live tab keeps refreshing. Too low and a slow network
    |          hands the record away mid-edit; too high and a crashed tab blocks
    |          it for that long (take-over is the escape hatch).
    */
    'locking' => [
        'timeout' => (int) env('CMS_LOCK_TIMEOUT', 180),
    ],

    /*
    |--------------------------------------------------------------------------
    | Media conversions (CmsMediaLibraryDriver)
    |--------------------------------------------------------------------------
    | Governs the image derivatives the media library pre-generates. Storage
    | cost scales with BOTH values: every library image yields the `responsive`,
    | `800`, `400`, `thumb` and `og` conversions plus one srcset candidate per
    | responsive step, so an uncapped 4000px original can occupy 25x its own
    | size on disk.
    |
    | max_width  longest edge (px) the `responsive` conversion — and with it
    |        every srcset candidate derived from it — is capped to. Applied as
    |        Fit::Max, so smaller images are never upscaled and aspect ratios
    |        are preserved. Sized against real viewports: a 1920px candidate
    |        already covers a 2x DPR phone and a 1x desktop. 0 disables the cap
    |        and restores the vendor default (candidates up to original size).
    | format  image format for the frontend conversions (`responsive`, `800`,
    |        `400`, `thumb`) and, because responsive candidates inherit the
    |        format of the conversion they derive from, for the srcset too.
    |        `webp` roughly halves the bytes at comparable quality. Set to
    |        `jpg` for installs that must serve pre-WebP clients.
    | og_format  kept SEPARATE from `format` on purpose: `og` feeds og:image,
    |        and messenger link-preview crawlers are the last holdout of
    |        WebP support. Change only if no one shares links to the site.
    |
    | Changing either value affects NEW conversions only. Re-run
    | `php artisan media-library:regenerate` for existing media, then
    | `php artisan cms:media:prune` to delete the superseded files.
    */
    'media' => [
        'max_width' => (int) env('CMS_MEDIA_MAX_WIDTH', 1920),
        'format' => env('CMS_MEDIA_FORMAT', 'webp'),
        'og_format' => env('CMS_MEDIA_OG_FORMAT', 'jpg'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Video conversion (ConvertsUploadedVideos)
    |--------------------------------------------------------------------------
    | recompress_threshold  size in bytes above which an upload that is ALREADY
    |        MP4 gets re-encoded anyway. Non-MP4 containers (.mov/.avi/.wmv) are
    |        converted regardless of size, so this value only governs the "large
    |        MP4" case. Raise it for sites whose hero videos are legitimately big;
    |        lower it in tests, so the size branch can be exercised with a tiny
    |        fixture instead of a multi-megabyte one.
    */
    'video' => [
        'recompress_threshold' => (int) env('CMS_VIDEO_RECOMPRESS_THRESHOLD', 10 * 1024 * 1024),
    ],

];
