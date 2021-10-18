<?php

declare(strict_types=1);

namespace App\Orders\Carts\Application\Query\Cart\TotalAmount;

use App\Orders\Carts\Domain\Model\Item\Item;
use App\Orders\Carts\Domain\Model\Item\ItemRepository;
use App\Orders\Products\Domain\Model\Product\ProductRepository;

final class TotalAmountHandler
{
    private ItemRepository $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function handle(TotalAmountQuery $query): int
    {
        $items = $this->itemRepository->findByCart($query->cartId());

        return $this->calculateCartTotalAmount($items);
    }

    private function calculateCartTotalAmount(array $items): int
    {
        $totalAmount = 0;

        /** @var Item $item */
        foreach ($items as $item) {
            $totalAmount += $item->quantity() * $item->product()->price();
        }

        return $totalAmount;
    }
}
