<?php

namespace Instante\Doctrine\Migrations;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\Export\Driver\PhpExporter;

class SchemaExporter
{
    private static $prologue = <<<EOT
<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\ClassMetadata;

return (function() use (\$namingStrategy) {
    \$_classes_ = [];

EOT;

    private static $epilogue = <<<EOT
    return \$_classes_;
})();

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
        $output = self::$prologue;
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
