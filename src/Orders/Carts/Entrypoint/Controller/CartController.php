<?php
declare(strict_types=1);

namespace App\Orders\Carts\Entrypoint\Controller;

use App\Orders\Carts\Application\Command\Cart\ConfirmCart\ConfirmCartCommand;
use App\Orders\Carts\Application\Command\Cart\DeleteCart\DeleteCartCommand;
use App\Orders\Carts\Application\Query\Cart\TotalAmount\TotalAmountQuery;
use App\Orders\Carts\Domain\Model\Item\Exception\ItemCanNotBeConfirmedException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CartController extends AbstractController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function totalCartAmount(Request $request): JsonResponse
    {
        $totalAmount = $this->commandBus->handle(new TotalAmountQuery($request->attributes->get('id')));

        return new JsonResponse(['total_amount' => $totalAmount], Response::HTTP_OK);
    }

    public function confirmCart(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(new ConfirmCartCommand($request->attributes->get('id')));
        } catch (\LogicException $ex) {
            return new JsonResponse(["message" => $ex->getMessage()],Response::HTTP_OK);
        } catch (ItemCanNotBeConfirmedException $ex) {
            return new JsonResponse(["message" => $ex->getMessage()], Response::HTTP_CONFLICT);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteCart(Request $request): JsonResponse
    {
        $this->commandBus->handle(new DeleteCartCommand($request->attributes->get('id')));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
