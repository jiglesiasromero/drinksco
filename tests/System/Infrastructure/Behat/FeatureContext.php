<?php
declare(strict_types=1);

namespace App\Tests\System\Infrastructure\Behat;

use App\Orders\Sellers\Domain\Model\Seller\Seller;
use App\Orders\Sellers\Domain\Model\Seller\SellerRepository;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use GuzzleHttp\Client;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\ResponseInterface;

/**
 * Class FeatureContext
 * @package App\Tests\System\Infrastructure\Behat
 */
final class FeatureContext implements Context
{
    private ResponseInterface $body;
    private string $baseUrl;
    private SellerRepository $sellerRepository;

    public function __construct(
        SellerRepository $sellerRepository,
        string $baseUrl
    ) {
        $this->sellerRepository = $sellerRepository;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @Given Send a :method request to :url with body:
     */
    public function iSendARequestToWithBody($method, $url, PyStringNode $body): void
    {
        $client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 2.0,
        ]);

        $this->body = $client->request($method, $url, ['body' => $body, 'http_errors' => false]);
    }

    /**
     * @Given Send a :method request to :url
     */
    public function iSendARequestTo(string $method, string $url): void
    {
        $client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 2.0,
        ]);
        $this->body = $client->request($method, $url, ['http_errors' => false]);
    }

    /**
     * @Then Response status code should be :expectedResponseCode
     */
    public function theResponseStatusCodeShouldBe(string $expectedResponseCode): void
    {
        Assert::assertSame((int)$expectedResponseCode, $this->body->getStatusCode());
    }

    /**
     * @Given A valid seller with id :id and name :name
     */
    public function aValidUserWithIdAndName(string $id, string $name): void
    {
        $seller = Seller::from($id, $name);
        $this->sellerRepository->add($seller);
    }

    /**
     * @Then Response content should be:
     */
    public function theResponseContentShouldBe(PyStringNode $string): void
    {
        Assert::assertEquals(
            json_decode((string) $string, true, 512, JSON_THROW_ON_ERROR),
            json_decode((string)$this->body->getBody(), true, 512, JSON_THROW_ON_ERROR),
            'The response is not equals'
        );
    }
}
