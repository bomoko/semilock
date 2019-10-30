<?php
use PHPUnit\Framework\TestCase;

use Semilock\ExtractVersions;

class ExtractVersionsTest extends TestCase
{

    public function testExtract()
    {
        $composer = json_decode(file_get_contents(__DIR__ . "/fixtures/composer.json"),
          true);
        $lock = json_decode(file_get_contents(__DIR__ . "/fixtures/composer.lock.old"),
          true);

        $lockPackageMap = ExtractVersions::getMappedLockDataFromFileArray($lock);

        $this->assertNotEquals($composer['require']['drupal/core'], $lockPackageMap['drupal/core']['version']);
        $transformedComposerJson = ExtractVersions::extract($composer, $lock);
        $this->assertEquals($transformedComposerJson['require']['drupal/core'], $lockPackageMap['drupal/core']['version']);
    }
}
