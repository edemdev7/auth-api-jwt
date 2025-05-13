<?php

namespace App\core;

class Router {
    private array $routes = [];

    /**
     * Ajoute une nouvelle route au système de routage.
     *
     * @param string $method La méthode HTTP pour la route (par exemple, GET, POST).
     * @param string $path Le chemin d'accès URL pour la route.
     * @param array $handler Le gestionnaire associé à la route, typiquement une fonction appelable ou une paire contrôleur/action.
     * @return void
     */
    public function addRoute(string $method, string $path, array $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    /**
     * Gère le routage des requêtes HTTP en faisant correspondre la méthode et le chemin de la requête aux routes définies.

     *

     * La méthode itère sur les routes enregistrées, en comparant la méthode HTTP et le chemin de l'URI de la requête.
     * Si une correspondance est trouvée, le contrôleur et l'action correspondants seront exécutés. Si aucune correspondance n'est trouvée,
     * une réponse HTTP 404 est renvoyée avec un message d'erreur au format JSON.
     *
     * @return mixed La valeur de retour de l'action du contrôleur correspondante, ou void lorsqu'aucune route ne correspond.
     */
    public function route() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                $controller = new $route['handler'][0];
                $action = $route['handler'][1];
                return $controller->$action();
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Route non trouvée']);
    }
}