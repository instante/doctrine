<?php

/* (c) Instante contributors 2014 */

namespace Instante\Doctrine;

/**
 * Use for Doctrine classes using DateTime as primary key.
 *
 * @author Richard Ejem <richard@ejem.cz>
 */
class DateKey extends \DateTime
{
    function __toString()
    {
        return $this->format('c');
    }

    static function fromDateTime(\DateTime $dateTime)
    {
        return new static($dateTime->format('c'));
    }
}
