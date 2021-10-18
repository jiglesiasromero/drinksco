<?php
declare(strict_types=1);

namespace App\Orders\Carts\Application\Command\Item\DecreaseItemAmount;

use App\Orders\Carts\Domain\Service\Item\DecreaseAmountItemFromCartUpdater;
use App\Orders\Carts\Domain\Service\Item\ItemFromCartFinder;

final class DecreaseItemAmountHandler
{
    private ItemFromCartFinder $itemFromCartFinder;
    private DecreaseAmountItemFromCartUpdater $decreaseAmountItemFromCartUpdater;

    public function __construct(
        ItemFromCartFinder $itemFromCartFinder,
        DecreaseAmountItemFromCartUpdater $decreaseAmountItemFromCartUpdater
    ) {
        $this->itemFromCartFinder = $itemFromCartFinder;
        $this->decreaseAmountItemFromCartUpdater = $decreaseAmountItemFromCartUpdater;
    }

    public function handle(DecreaseItemAmountCommand $command): void
    {
        $item = $this->itemFromCartFinder->execute($command->itemId());

        $this->decreaseAmountItemFromCartUpdater->execute($item);
    }
}
