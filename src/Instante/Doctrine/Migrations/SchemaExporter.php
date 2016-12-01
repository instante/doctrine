<?php

namespace Instante\Doctrine\Migrations;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\Export\Driver\PhpExporter;

class SchemaExporter
{
    private static $prologue = <<<EOT
<?php

/* version unique id: %s
 * This file is generated by Instante\\Doctrine\\Migrations.
 * If merge conflict happens on this file, you went into a tricky situation
 * where you modified the database model in a different way in two different branches.
 * Recommended solution:
 * 1. abort the merge and do a rebase (if you aren't already doing)
 * 2. on every commit where you experience a conflict,
 *    some version files (VersionXXXXX.php) should be also in conflict.
 *    TODO create a tool that does 2a..2e
 *    a. Locate all Version files that are in conflict or have higher version number than the
 *       conflicting files (in the branch being rebased). Let's call them "Conflicting versions"
 *    b. Pick all Conflicting versions from the branch being rebased and back them up aside.
 *    c. For Conflicting versions that exist in both branches, drop all changes ("resolve using mine").
 *    d. Remove Conflicting versions existing only in the branch being rebased from the migrations folder.
 *    e. Drop changes in this file ("resolve using mine").
 *    f. Create new migration as you usually do (pre-generate it using migrations:diff and adjust
 *       by you need - eventually restore manual mechanisms like data migration from old scripts that you
 *       put aside in 2b.
 *    g. You can remove the files you put aside in 2b now.
 *    h. Finish current commit by continuing the rebase ("git rebase --continue")
 */

namespace Instante\Doctrine;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\ClassMetadata;

\$createMigration = function() use (\$namingStrategy) {
    \$_classes_ = [];

EOT;

    private static $epilogue = <<<EOT
    return \$_classes_;
};
return \$createMigration();

EOT;

    private static $prependToClassDef = <<<EOT
    \$metadata =  new ClassMetadata(<class>, \$namingStrategy);

EOT;

    private static $appendToClassDef = <<<EOT
    \$_classes_[] = \$metadata; 

EOT;


    /**
     * @param EntityManager $em
     * @return string php code
     */
    public function export(EntityManager $em)
    {
        $exporter = $this->createExporter();
        $output = sprintf(self::$prologue, uniqid());
        foreach ($em->getMetadataFactory()->getAllMetadata() as $metadata) {
            /** @var ClassMetadata $metadata */
            $output .= $this->processSingleExport($exporter->exportClassMetadata($metadata), $metadata->getName());
        }
        $output .= self::$epilogue;
        return $output;
    }

    /** @return PhpExporter */
    private function createExporter()
    {
        $exporter = new PhpExporter();
        $exporter->setOverwriteExistingFiles(true);
        return $exporter;
    }

    private function processSingleExport($metadataPhpCode, $entityClassName)
    {
        $lines = array_slice(explode("\n", $metadataPhpCode), 4);
        return
            str_replace('<class>', $this->phpEscapeString($entityClassName), self::$prependToClassDef)
            . implode("\n", array_map(function($str) { return '    ' . $str; }, $lines))
            . "\n"
            . self::$appendToClassDef;
    }

    private function phpEscapeString($str) {
        $str = str_replace(['\'', '\\'], ['\\\'', '\\\\'], $str);
        return "'$str'";
    }
}
