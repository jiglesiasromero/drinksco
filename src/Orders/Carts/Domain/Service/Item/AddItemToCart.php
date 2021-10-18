<?php

declare(strict_types=1);

namespace App\Orders\Carts\Domain\Service\Item;

use App\Orders\Carts\Domain\Model\Item\Item;
use App\Orders\Carts\Domain\Model\Item\ItemRepository;
use App\Orders\Carts\Domain\Model\Item\ValueObject\Product;

final class AddItemToCart
{
    private ItemRepository $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function execute(Product $product, string $cartId): void
    {
        $item = Item::create($product, $cartId);

        $this->itemRepository->add($item);
    }
}
