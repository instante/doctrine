<?php

namespace Instante\Doctrine\Migrations;

interface IVersionNamingStrategy
{
    /**
     * @param string[] $versionChain
     * @return string
     */
    public function createNewVersionName(array $versionChain);
}
