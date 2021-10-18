<?php
declare(strict_types=1);

namespace App\Orders\Carts\Application\Command\Cart\ConfirmCart;

use App\Orders\Carts\Domain\Service\Cart\ConfirmItemsFromCart;

final class ConfirmCartHandler
{
    private ConfirmItemsFromCart $confirmItemsFromCart;

    public function __construct(ConfirmItemsFromCart $confirmItemsFromCart)
    {
        $this->confirmItemsFromCart = $confirmItemsFromCart;
    }

    public function handle(ConfirmCartCommand $command): void
    {
        $this->confirmItemsFromCart->execute($command->cartId());
    }
}
