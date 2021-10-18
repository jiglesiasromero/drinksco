<?php
declare(strict_types=1);

namespace App\Orders\Carts\Domain\Service\Item;

use App\Orders\Carts\Domain\Model\Item\Item;

interface ByIdAndCartIdItemFinder
{
    public function execute(string $itemId, string $cartId): ?Item;
}
