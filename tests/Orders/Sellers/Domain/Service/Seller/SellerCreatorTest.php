<?php
declare(strict_types=1);

namespace Orders\Sellers\Domain\Service\Seller;

use App\Orders\Sellers\Domain\Model\Seller\SellerRepository;
use App\Orders\Sellers\Domain\Service\Seller\SellerCreator;
use PHPUnit\Framework\TestCase;

final class SellerCreatorTest extends TestCase
{
    /**
     * @test
     */
    public function given_seller_data_when_create_then_it_creates(): void
    {
        $name = 'seller-name-test';

        $repository = $this->createMock(SellerRepository::class);
        $repository
            ->expects(self::once())
            ->method('add')
        ;

        $sellerCreator = new SellerCreator($repository);
        $sellerCreator->execute($name);
    }
}
