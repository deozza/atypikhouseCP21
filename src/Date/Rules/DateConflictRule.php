<?php


namespace App\Date\Rules;


use Deozza\PhilarmonyCoreBundle\Rules\RuleInterface;
use Deozza\PhilarmonyCoreBundle\Service\DatabaseSchema\DatabaseSchemaLoader;
use Doctrine\ORM\EntityManagerInterface;

class DateConflictRule implements RuleInterface
{
    const ERROR_DATE = "DATE_BEFORE_TODAY";
    public function supports($entity, $posted, $method): bool
    {
        return in_array($method, ['POST', 'PATCH'])
            &&
            $entity->getKind() === "reservation"
            ;
    }

    public function decide($entity, $posted, $method, EntityManagerInterface $em, DatabaseSchemaLoader $schemaLoader): ?array
    {
        $today = new \DateTime('now');
        $todayTimestamp = $today->getTimestamp();

        $coming_at = new \DateTime($posted['coming_at']);

        if($todayTimestamp > $coming_at->getTimestamp())
        {
            return ['conflict' => ['coming_at'=> self::ERROR_DATE]];
        }

        return null;
    }
}