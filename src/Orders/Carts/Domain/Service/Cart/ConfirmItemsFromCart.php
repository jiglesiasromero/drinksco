<?php

declare(strict_types=1);

namespace App\Orders\Carts\Domain\Service\Cart;

use App\Orders\Carts\Domain\Model\Item\Exception\ItemCanNotBeConfirmedException;
use App\Orders\Carts\Domain\Model\Item\Item;
use App\Orders\Carts\Domain\Model\Item\ItemRepository;

final class ConfirmItemsFromCart
{
    private ItemRepository $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function execute(string $cartId): void
    {
        $items = $this->itemRepository->findByCart($cartId);

        if ([] === $items) {
            throw new \LogicException("There is no items to confirm");
        }

        $this->assertItemsCartCanBeConfirmed($items);

        $this->updateStatusToFinishedForItems($items);
    }

    private function assertItemsCartCanBeConfirmed(array $items): void
    {
        /** @var Item $item */
        foreach ($items as $item) {
            if (false === $item->status()->isPending()) {
                throw ItemCanNotBeConfirmedException::from($item->id());
            }
        }
    }

    private function updateStatusToFinishedForItems(array $items): void
    {
        /** @var Item $item */
        foreach ($items as $item) {
            $item->confirmItem();

            $this->itemRepository->update($item);
        }
    }
}
