<?php

namespace Instante\Doctrine\Migrations;

use Nette\InvalidStateException;

class LinearVersionNamingStrategy implements IVersionNamingStrategy
{
    private $padZerosLength = 6;

    /**
     * {@inheritdoc}
     */
    public function createNewVersionName(array $versionChain)
    {
        $lastVersion = end($versionChain);
        $newVersion = str_pad((string)($lastVersion + 1), $this->padZerosLength, '0', STR_PAD_LEFT);
        if (in_array($newVersion, $versionChain)) {
            throw new InvalidStateException('Version chain is non-linear, cannot use linear naming strategy');
        }
        return $newVersion;
    }

    /** @return int */
    public function getPadZerosLength()
    {
        return $this->padZerosLength;
    }

    /**
     * @param int $padZerosLength
     * @return $this
     */
    public function setPadZerosLength($padZerosLength)
    {
        $this->padZerosLength = $padZerosLength;
        return $this;
    }
}
