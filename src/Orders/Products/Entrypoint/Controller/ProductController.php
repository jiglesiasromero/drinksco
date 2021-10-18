<?php

declare(strict_types=1);

namespace App\Orders\Products\Entrypoint\Controller;

use App\Orders\Products\Application\Command\Product\Delete\DeleteProductCommand;
use App\Orders\Products\Application\Command\Product\Register\RegisterProductCommand;
use App\Orders\Products\Domain\Model\Product\Exception\ProductNotFoundException;
use App\Orders\Sellers\Domain\Model\Seller\Exception\SellerNotFoundException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ProductController extends AbstractController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function create(Request $request): JsonResponse
    {
        $body = new ParameterBag(
            \json_decode(
                $request->getContent(),
                true,
            ),
        );

        try {
            $this->commandBus->handle(
                new RegisterProductCommand(
                    $body->get('name'),
                    $body->get('price'),
                    $body->get('seller_id')
                )
            );
        } catch (SellerNotFoundException $ex) {
            return new JsonResponse(["message" => $ex->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(null, Response::HTTP_CREATED,);
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(new DeleteProductCommand($request->attributes->get('id'),));
        } catch (SellerNotFoundException $ex) {
            return new JsonResponse(["message" => $ex->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (ProductNotFoundException $ex) {
            return new JsonResponse(["message" => $ex->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
