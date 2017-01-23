<?php

namespace Instante\Doctrine\Migrations;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

class FileSchema
{
    /** @var ClassMetadata[] */
    private $metadata;

    /** @var string[] - record [0] is the oldest version, last record is current version*/
    private $versionChain;

    /**
     * @param ClassMetadata[] $metadata
     * @param string[] $versionChain
     */
    public function __construct(array $metadata, array $versionChain)
    {
        $this->metadata = $metadata;
        $this->versionChain = $versionChain;
    }

    public static function createEmpty()
    {
        return new self([], []);
    }

    /** @return string[] */
    public function getVersionChain()
    {
        return $this->versionChain;
    }

    public function getSchema(EntityManager $entityManager)
    {
        $tool = new SchemaTool($entityManager);
        return $tool->getSchemaFromMetadata($this->metadata);
    }
}
