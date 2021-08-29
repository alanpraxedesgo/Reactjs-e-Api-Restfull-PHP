<?php


namespace src\Middleware;

use Models\Users;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class PermissionMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler) : ResponseInterface
    {
        $dataToken = $request->getAttribute('token');

        if(array_key_exists('id',$dataToken)){
            $user = new Users();
            if(!$user->validLoginMobile($dataToken['id'], $dataToken['cpf'])){
                return $this->unauthorized();
            }

        }else{
            return $this->unauthorized();
        }

        return $handler->handle($request);

    }

    private function unauthorized(){
        $response = new Response();
        $error = [
            'statusCode' => 401,
            'message' => 'Unauthorized',
        ];
        $response->getBody()->write(json_encode($error));
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(401);
    }
}