<?php

declare(strict_types=1);

namespace App\Orders\Carts\Application\Command\Item\RemoveItem;

use App\Orders\Carts\Domain\Service\Item\ItemFromCartFinder;
use App\Orders\Carts\Domain\Service\Item\ItemFromCartRemover;

final class RemoveItemHandler
{
    private ItemFromCartFinder $itemFromCartFinder;
    private ItemFromCartRemover $itemFromCartRemover;

    public function __construct(ItemFromCartFinder $itemFromCartFinder, ItemFromCartRemover $itemFromCartRemover)
    {
        $this->itemFromCartFinder = $itemFromCartFinder;
        $this->itemFromCartRemover = $itemFromCartRemover;
    }

    public function handle(RemoveItemCommand $command): void
    {
        $item = $this->itemFromCartFinder->execute($command->itemId());

        $this->itemFromCartRemover->execute($item->id());
    }
}
