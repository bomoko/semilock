<?php

use PHPUnit\Framework\TestCase;

use Localheinz\Json\Normalizer\Json;

class GenerateCommandTest extends TestCase
{

    public function testJsonOutput()
    {
        $composer = json_decode(file_get_contents(__DIR__ . "/fixtures/composer.json"), true);
        $lock = json_decode(file_get_contents(__DIR__ . "/fixtures/composer.lock.old"), true);

        $cmd = exec(__DIR__ . '/../../bin/semilock semilock:generate ' . __DIR__ . '/fixtures/composer.json ' . __DIR__ . '/fixtures/composer.lock.old', $output);

        $json = Json::fromEncoded(json_encode($output, JSON_UNESCAPED_SLASHES));

        $this->assertJson($json);
        // Run the below cmd to output new composer.json
        // $ php bin/semilock semilock:generate tests/unit/fixtures/composer.json tests/unit/fixtures/composer.lock.old -o composer-test.json
    }
}
