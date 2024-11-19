<?php

namespace App\Infrasctructure\Http;

class Response
{
    public function json(mixed $data = [], int $status = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function pdf(string $pdfContent, int $status = 200): void
    {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline;');
        header('Content-Length: ' . strlen($pdfContent));
        http_response_code($status);

        echo file_get_contents($pdfContent);
        exit;
    }
}