<?php

class APIHeaderMiddleware {
  public function __invoke($request, $response, $next) {
    $response = $next($request, $response);
    return $response->withHeader('Access-Control-Allow-Origin', APP_ORIGIN)
                    ->withHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Requested-With, X-PINGOTHER, X-File-Name, Cache-Control, APP-ID, TOKEN')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                    ->withHeader('Access-Control-Allow-Credentials', 'true')
                    ->withHeader('X-Requested-With', 'XMLHttpRequest')
                    ->withHeader('Content-Type', 'application/json');
  }
}

class AuthMidleware {
    public function __invoke($request, $response, $next) {
        $token = $request->getHeader('TOKEN');

        if (is_array($token) && isset($token[0]) && $token[0] !== '') {
            $clientToken = $token[0];
            $authClient = new Auth\AuthClientToken();

            if ($authClient->Authorized($clientToken)) {
                $response = $next($request, $response);
            } else {
                throw new Exception($authClient->message);
            }
        } else {
            throw new Exception('no token passed.');
        }
        return $response;
    }
}

class Maintenance {
  public function __invoke($request, $response, $next) {
    if (ISOFFLINE && $request->getUri()->getPath() !== '/offline') {
      return $response->withStatus(302)->withHeader('Location', '/offline');
    }
    return $next($request, $response);
  }
}

class JsonResponseMiddleware {
  public function __invoke($request, $response, $next) {
    $response = $next($request, $response);
    return $response->withHeader('Content-Type', 'application/json')
                    ->getBody()->write(')]}\',\n');
  }
}