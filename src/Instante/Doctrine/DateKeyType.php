<?php

/* (c) Instante contributors 2014 */

namespace Instante\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Use for Doctrine classes using DateTime as primary key.
 *
 * @author Richard Ejem <richard@ejem.cz>
 */
class DateKeyType extends \Doctrine\DBAL\Types\DateType{
    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform) {
        $value = parent::convertToPHPValue($value, $platform);
        if ($value !== NULL) {
            $value = DateKey::fromDateTime($value);
        }
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'datekey';
    }
}
