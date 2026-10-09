<?php

namespace Mmoollllee\Cms\Support\Routing;

use Illuminate\Database\Eloquent\Model;
use Mmoollllee\Cms\Contracts\AddressReservation;
use Mmoollllee\Cms\Contracts\AddressReservations;

/**
 * The content engine's default: nothing holds an address, a rename leaves no
 * forwarding address behind. The site layer replaces it with its redirects.
 */
class NoAddressReservations implements AddressReservations
{
    public function followRename(Model $content): void {}

    public function deactivateInbound(Model $content): int
    {
        return 0;
    }

    public function shadowing(int|string|null $tenantId, ?string $path, ?Model $content = null): ?AddressReservation
    {
        return null;
    }

    public function firstShadowedInSubtree(Model $content, array &$seen = []): ?array
    {
        return null;
    }

    public function release(AddressReservation $reservation): void {}
}
