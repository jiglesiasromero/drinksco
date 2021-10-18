<?php

declare(strict_types=1);

namespace App\Orders\Sellers\Entrypoint\Controller;

use App\Orders\Sellers\Application\Command\Seller\Delete\DeleteSellerCommand;
use App\Orders\Sellers\Application\Command\Seller\Register\RegisterSellerCommand;
use App\Orders\Sellers\Domain\Model\Seller\Exception\SellerNotFoundException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SellerController extends AbstractController
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

        $this->commandBus->handle(new RegisterSellerCommand($body->get('name')));

        return new JsonResponse(null, Response::HTTP_CREATED,);
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->commandBus->handle(new DeleteSellerCommand($request->attributes->get('id')));
        } catch (SellerNotFoundException $ex) {
            return new JsonResponse(["message" => $ex->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
