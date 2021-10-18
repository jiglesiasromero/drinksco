<?php

declare(strict_types=1);

namespace App\Orders\Carts\Domain\Service\Item;

use App\Orders\Carts\Domain\Model\Item\Item;
use App\Orders\Carts\Domain\Model\Item\ItemRepository;

final class IncreaseAmountItemFromCartUpdater
{
    private ItemRepository $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function execute(Item $item): void
    {
        $item->increaseAmount();

        $this->itemRepository->update($item);
    }
}
