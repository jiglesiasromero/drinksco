<?php
declare(strict_types=1);

namespace Orders\Sellers\Domain\Service\Seller;

use App\Orders\Sellers\Domain\Model\Seller\SellerRepository;
use App\Orders\Sellers\Domain\Service\Seller\SellerDeleter;
use PHPUnit\Framework\TestCase;

final class SellerDeleterTest extends TestCase
{
    /**
     * @test
     */
    public function given_seller_data_when_delete_then_it_deletes(): void
    {
        $id = '086a6ea0-32f3-471a-87a3-89feb15f2627';

        $repository = $this->createMock(SellerRepository::class);
        $repository
            ->expects(self::once())
            ->method('delete')
        ;

        $sellerDeleter = new SellerDeleter($repository);
        $sellerDeleter->execute($id);
    }
}
