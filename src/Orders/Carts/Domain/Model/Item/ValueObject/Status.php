<?php

declare(strict_types=1);

namespace App\Orders\Carts\Domain\Model\Item\ValueObject;

final class Status
{
    private const PENDING_STATUS = 'PENDING';
    private const CONFIRMED_STATUS = 'CONFIRMED';
    private const CART_STATUS = [self::PENDING_STATUS, self::CONFIRMED_STATUS];

    private string $value;

    private function __construct(string $value)
    {
        if (false === \in_array($value, self::CART_STATUS)) {
            throw new \InvalidArgumentException('Not valid status');
        }

        $this->value = $value;
    }

    public static function from(string $value): self
    {
        return new self($value);
    }

    public static function fromPending(): self
    {
        return new self(self::PENDING_STATUS);
    }

    public static function fromConfirmed(): self
    {
        return new self(self::CONFIRMED_STATUS);
    }

    public function isPending(): bool
    {
        return $this->value === self::PENDING_STATUS;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function changeStatus(Status $status): void
    {
        if (true === $this->canChangeStatus($status)) {
            $this->value = $status->value();
        } else {
            throw new \InvalidArgumentException("Status change not allowed");
        }
    }

    private function canChangeStatus(Status $status): bool
    {
        $allowedStatusChanges = [
            self::PENDING_STATUS => [self::CONFIRMED_STATUS]
        ];

        $validStatusChanges = \array_key_exists($this->value, $allowedStatusChanges)
            ? $allowedStatusChanges[$this->value]
            : [];

        return \in_array($status->value(), $validStatusChanges);
    }
}
