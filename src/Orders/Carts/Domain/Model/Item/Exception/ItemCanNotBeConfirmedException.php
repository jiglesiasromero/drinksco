<?php
declare(strict_types=1);

namespace App\Orders\Carts\Domain\Model\Item\Exception;

final class ItemCanNotBeConfirmedException extends \Exception
{
    private string $id;

    private function __construct(string $id, string $message)
    {
        parent::__construct($message);

        $this->id = $id;
    }

    public static function from(string $id): self
    {
        return new self($id, 'Item can not be confirmed ' . $id);
    }

    public function id(): string
    {
        return $this->id;
    }
}
