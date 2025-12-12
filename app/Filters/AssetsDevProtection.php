<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AssetsDevProtection implements FilterInterface
{
    /**
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Só executa em produção
        if (ENVIRONMENT === 'production') {
            
            // Pega o caminho da URI
            $uri = $request->getUri()->getPath();

            // Se a URI começar com "development/assets"
            if (str_starts_with($uri, 'development/assets')) {
                
                // Retorna erro 403 - Acesso Proibido
                return service('response')
                    ->setStatusCode(403)
                    ->setBody('Acesso proibido a recursos de desenvolvimento em ambiente de produção.');
            }
        }
    }

    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada a fazer aqui
    }
}
