<?php

namespace Mmoollllee\Cms\Contracts;

use Illuminate\Database\Eloquent\Model;
use Mmoollllee\Cms\Support\Routing\NoAddressReservations;

/**
 * Addresses something other than content may hold on a site — the site layer's
 * redirects — and what a rename or a delete of content does to them.
 *
 * The content engine asks this instead of the redirect subsystem directly: the
 * path rules and the "Adresse übernehmen" action of the content form, and the
 * saved/deleting hooks of {@see \Mmoollllee\Cms\Concerns\Content\GeneratesPathAndSlug}.
 * A host without redirects keeps the default, {@see NoAddressReservations}: no
 * address is ever held, and a rename leaves nothing behind.
 */
interface AddressReservations
{
    /** Leave the address the content had behind it, if it moved. */
    public function followRename(Model $content): void;

    /**
     * Stop forwarding to content about to be deleted.
     *
     * @return int how many reservations stopped
     */
    public function deactivateInbound(Model $content): int;

    /** The reservation that would hide the content at this address, if any. */
    public function shadowing(int|string|null $tenantId, ?string $path, ?Model $content = null): ?AddressReservation;

    /**
     * The first descendant a move of the content would put on a held address.
     *
     * @param  array<int|string, true>  $seen  guards a malformed parent_id cycle
     * @return array{record: Model, redirect: AddressReservation}|null
     */
    public function firstShadowedInSubtree(Model $content, array &$seen = []): ?array;

    /** Give the address free for good, as "Adresse übernehmen" asks. */
    public function release(AddressReservation $reservation): void;
}
