<?php

namespace App\core;

class Request {
    private array $data;

    /**
     * Initialise l'instance en décodant les données JSON d'entrée du corps de la requête
     * et en les affectant à la propriété `$data`.
     * @return void
     */
    public function __construct() {
        $this->data = json_decode(file_get_contents('php://input'), true) ?? [];
    }

    /**
     * Récupère les données JSON décodées stockées dans la propriété `$data`.
     * @return array Les données JSON sous forme de tableau associatif.
     */
    public function getJson(): array {
        return $this->data;
    }

    /**
     * Récupère la valeur d'un en-tête HTTP spécifique à partir de la requête du serveur.
     * Convertit le nom de l'en-tête fourni au format de variable serveur approprié.
     *
     * @param string $name Le nom de l'en-tête HTTP à récupérer.
     * @return string|null La valeur de l'en-tête HTTP demandée, ou null si l'en-tête n'est pas trouvée.
     */
    public function getHeader(string $name): ?string {
        $headerName = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
        return $_SERVER[$headerName] ?? null;
    }
}