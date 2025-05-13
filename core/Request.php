<?php

namespace App\core;

class Request {
    private array $data;

    public function __construct() {
        $this->data = json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public function getJson(): array {
        return $this->data;
    }

    public function getHeader(string $name): ?string {
        $headerName = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
        return $_SERVER[$headerName] ?? null;
    }
}