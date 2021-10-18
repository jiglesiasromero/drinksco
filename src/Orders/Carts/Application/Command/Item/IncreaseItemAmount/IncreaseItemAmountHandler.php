<?php
declare(strict_types=1);

namespace App\Orders\Carts\Application\Command\Item\IncreaseItemAmount;

use App\Orders\Carts\Domain\Service\Item\IncreaseAmountItemFromCartUpdater;
use App\Orders\Carts\Domain\Service\Item\ItemFromCartFinder;

final class IncreaseItemAmountHandler
{
    private ItemFromCartFinder $itemFromCartFinder;
    private IncreaseAmountItemFromCartUpdater $increaseAmountItemFromCartUpdater;

    public function __construct(
        ItemFromCartFinder $itemFromCartFinder,
        IncreaseAmountItemFromCartUpdater $increaseAmountItemFromCartUpdater
    ) {
        $this->itemFromCartFinder = $itemFromCartFinder;
        $this->increaseAmountItemFromCartUpdater = $increaseAmountItemFromCartUpdater;
    }

    public function handle(IncreaseItemAmountCommand $command): void
    {
        $item = $this->itemFromCartFinder->execute($command->itemId());

        $this->increaseAmountItemFromCartUpdater->execute($item);
    }
}
