<?php

declare(strict_types=1);

namespace App\Orders\Carts\Domain\Service\Item;

use App\Orders\Carts\Domain\Model\Item\Exception\ItemNotFoundException;
use App\Orders\Carts\Domain\Model\Item\Item;
use App\Orders\Carts\Domain\Model\Item\ItemRepository;

final class ItemFromCartFinder
{
    private ItemRepository $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function execute(string $id): Item
    {
        $item = $this->itemRepository->find($id);

        if (null === $item) {
            throw ItemNotFoundException::from($id);
        }

        return $item;
    }
}
