<?php
declare(strict_types=1);

namespace Orders\Sellers\Domain\Service\Seller;

use App\Orders\Sellers\Domain\Model\Seller\Exception\SellerNotFoundException;
use App\Orders\Sellers\Domain\Model\Seller\Seller;
use App\Orders\Sellers\Domain\Model\Seller\SellerRepository;
use App\Orders\Sellers\Domain\Service\Seller\SellerFinder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SellerFinderTest extends TestCase
{
    private MockObject $repository;
    private Seller $seller;
    private string $id;
    private string $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(SellerRepository::class);
        $this->id = "93f05412-1c88-41b3-8d00-72d31437054a";
        $this->name = "name";
        $this->seller = Seller::from($this->id, $this->name);
    }

    /**
     * @test
     */
    public function given_seller_id_when_seller_exists_then_return_seller(): void
    {
        $this->repository
            ->expects(self::once())
            ->method('find')
            ->willReturn($this->seller);

        $sellerFinder = new SellerFinder($this->repository);
        $sellerFinder->execute($this->id);
    }

    /**
     * @test
     */
    public function given_seller_id_when_seller_does_not_exist_then_return_exception(): void
    {
        $this->repository
            ->expects(self::once())
            ->method('find')
            ->willReturn(null);

        $this->expectException(SellerNotFoundException::class);

        $sellerFinder = new SellerFinder($this->repository);
        $sellerFinder->execute($this->id);
    }
}
