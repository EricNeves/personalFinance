<?php

namespace App\Adapters\Out\Persistence\Repositories;

use App\Domain\Entities\Image;
use App\Domain\Ports\Out\ImageRepositoryPort;
use PDO;

class ImagePostgresRepository implements ImageRepositoryPort
{
    public function __construct(private readonly PDO $db)
    {
    }
    
    public function save(Image $image): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO
                user_images(id, filename, path, mime_type, size, user_id, created_at)
            VALUES
                (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $image->getId(),
            $image->getFilename(),
            $image->getPath(),
            $image->getMimeType(),
            $image->getSize(),
            $image->getUserID(),
            $image->getCreatedAt()
        ]);
        
        if ($stmt->rowCount() > 0) {
            return true;
        }
        
        return false;
    }
}