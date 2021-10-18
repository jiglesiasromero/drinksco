<?php
declare(strict_types=1);

namespace App\Orders\Carts\Application\Command\Cart\DeleteCart;

use App\Orders\Carts\Domain\Model\Item\Item;
use App\Orders\Carts\Domain\Model\Item\ItemRepository;

final class DeleteCartHandler
{
    private ItemRepository $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function handle(DeleteCartCommand $command): void
    {
        $items = $this->itemRepository->findByCart($command->cartId());

        if ([] === $items) {
            return ;
        }

        /** @var Item $item */
        foreach ($items as $item) {
            $this->itemRepository->delete($item->id());
        }
    }
}
