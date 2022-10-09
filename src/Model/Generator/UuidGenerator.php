<?php

namespace Noman\Assignment\Model\Generator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Exception;
use Ramsey\Uuid\Doctrine\UuidOrderedTimeGenerator;
use Ramsey\Uuid\Uuid;

class UuidGenerator extends UuidOrderedTimeGenerator
{
    /**
     * Generate an identifier
     *
     * @param EntityManager $em
     * @param Entity $entity
     *
     * @return string
     * @throws Exception
     */
    public function generate(EntityManager $em, $entity): string
    {
        return Uuid::uuid4()->toString(); // return the string representation
    }
}
