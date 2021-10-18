<?php

declare(strict_types=1);

namespace App\Orders\Carts\Application\Command\Item\AddItem;

use App\Orders\Carts\Domain\Model\Item\ValueObject\Product;
use App\Orders\Carts\Domain\Service\Item\AddItemToCart;
use App\Orders\Carts\Domain\Service\Item\ByIdAndCartIdItemFinder;
use App\Orders\Carts\Domain\Service\Item\IncreaseAmountItemFromCartUpdater;
use App\Orders\Products\Domain\Service\Product\ProductFinder;

final class AddItemHandler
{
    private ProductFinder $productFinder;
    private AddItemToCart $addItemToCart;
    private ByIdAndCartIdItemFinder $byIdAndCartIdItemFinder;
    private IncreaseAmountItemFromCartUpdater $increaseAmountItemFromCartUpdater;

    public function __construct(
        ProductFinder $productFinder,
        AddItemToCart $addItemToCart,
        ByIdAndCartIdItemFinder $byIdAndCartIdItemFinder,
        IncreaseAmountItemFromCartUpdater $increaseAmountItemFromCartUpdater
    ) {
        $this->productFinder = $productFinder;
        $this->addItemToCart = $addItemToCart;
        $this->byIdAndCartIdItemFinder = $byIdAndCartIdItemFinder;
        $this->increaseAmountItemFromCartUpdater = $increaseAmountItemFromCartUpdater;
    }

    public function handle(AddItemCommand $command): void
    {
        $product = $this->productFinder->execute($command->productId());

        $itemFromCart = $this->byIdAndCartIdItemFinder->execute($command->productId(), $command->cartId());

        if (null === $itemFromCart) {
            $this->addItemToCart->execute(
                Product::from($product->id(), $product->price()),
                $command->cartId());
            return ;
        }

        $this->increaseAmountItemFromCartUpdater->execute($itemFromCart);
    }
}
