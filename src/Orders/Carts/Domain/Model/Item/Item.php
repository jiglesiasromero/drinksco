<?php

declare(strict_types=1);

namespace App\Orders\Carts\Domain\Model\Item;

use App\Orders\Carts\Domain\Model\Item\ValueObject\Product;
use App\Orders\Carts\Domain\Model\Item\ValueObject\Status;
use Ramsey\Uuid\Uuid;

final class Item
{
    private string $id;
    private Product $product;
    private int $quantity;
    private string $cartId;
    private Status $status;

    private function __construct(
        string $id,
        Product $product,
        int $quantity,
        string $cartId,
        Status $status
    ) {
        $this->id = $id;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->cartId = $cartId;
        $this->status = $status;
    }

    public static function from(
        string $id,
        Product $product,
        int $quantity,
        string $cartId,
        Status $status
    ): self {
        return new self($id, $product, $quantity, $cartId, $status);
    }

    public static function create(Product $product, string $cartId): self
    {
        return new self(
            Uuid::uuid4()->toString(),
            $product,
            1,
            $cartId,
            Status::fromPending(),
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function cartId(): string
    {
        return $this->cartId;
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function increaseAmount(): void
    {
        $this->quantity = $this->quantity + 1;
    }

    public function decreaseAmount(): void
    {
        $this->quantity = $this->quantity - 1;
    }

    public function confirmItem(): void
    {
        $this->status->changeStatus(Status::fromConfirmed());
    }
}
