<?php
declare(strict_types=1);

namespace App\Orders\Carts\Application\Command\Item\DecreaseItemAmount;

final class DecreaseItemAmountCommand
{
    private string $itemId;

    public function __construct(string $itemId)
    {
        $this->itemId = $itemId;
    }

    public function itemId(): string
    {
        return $this->itemId;
    }
}
