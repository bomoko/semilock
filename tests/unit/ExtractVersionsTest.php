<?php
use PHPUnit\Framework\TestCase;

use ComposerFixed\ExtractVersions;


class ExtractVersionsTest extends TestCase
{

    public function testExtract()
    {
        $composer = json_decode(file_get_contents(__DIR__ . "/fixtures/composer.json"),
          true);
        $lock = json_decode(file_get_contents(__DIR__ . "/fixtures/composer.lock"),
          true);

        $lockPackageMap = ExtractVersions::getMappedLockDataFromFileArray($lock);

        $this->assertNotEquals($composer['require']['drupal/core'], $lockPackageMap['drupal/core']);
        $transformedComposerJson = ExtractVersions::extract($composer, $lock);
        $this->assertEquals($transformedComposerJson['require']['drupal/core'], $lockPackageMap['drupal/core']['version']);
    }

}
