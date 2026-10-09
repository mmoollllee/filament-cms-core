<?php

namespace Mmoollllee\Cms\Contracts;

/**
 * One address held on a site, as the content form names it to the editor.
 */
interface AddressReservation
{
    /** @return int|string */
    public function getKey();

    /** The address held. */
    public function reservedPath(): string;

    /** Where the address leads instead, if anywhere. */
    public function resolvedTarget(): ?string;
}
