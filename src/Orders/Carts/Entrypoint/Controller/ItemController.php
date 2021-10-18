<?php

declare(strict_types=1);

namespace App\Orders\Carts\Entrypoint\Controller;

use App\Orders\Carts\Application\Command\Item\AddItem\AddItemCommand;
use App\Orders\Carts\Application\Command\Item\DecreaseItemAmount\DecreaseItemAmountCommand;
use App\Orders\Carts\Application\Command\Item\IncreaseItemAmount\IncreaseItemAmountCommand;
use App\Orders\Carts\Application\Command\Item\RemoveItem\RemoveItemCommand;
use App\Orders\Carts\Domain\Model\Item\Exception\ItemNotFoundException;
use App\Orders\Products\Domain\Model\Product\Exception\ProductNotFoundException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ItemController extends AbstractController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function addProductToCart(Request $request): JsonResponse
    {
        $body = new ParameterBag(
            \json_decode(
                $request->getContent(),
                true,
            ),
        );

        try {
            $this->commandBus->handle(
                new AddItemCommand(
                    $body->get('product_id'),
                    $body->get('cart_id'),
                )
            );
        } catch (ProductNotFoundException $ex) {
            return new JsonResponse(["message" => $ex->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\InvalidArgumentException $ex) {
            return new JsonResponse(["message" => $ex->getMessage()], Response::HTTP_CONFLICT);
        }

        return new JsonResponse(null, Response::HTTP_CREATED);
    }

    public function removeFromCart(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(
                new RemoveItemCommand(
                    $request->attributes->get('id')
                )
            );
        } catch (ItemNotFoundException $ex) {
            return new JsonResponse(["message" => $ex->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function increaseQuantity(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(new IncreaseItemAmountCommand($request->attributes->get('id'),));
        } catch (ItemNotFoundException $ex) {
            return new JsonResponse(["message" => $ex->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function decreaseQuantity(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(new DecreaseItemAmountCommand($request->attributes->get('id'),));
        } catch (ItemNotFoundException $ex) {
            return new JsonResponse(["message" => $ex->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
