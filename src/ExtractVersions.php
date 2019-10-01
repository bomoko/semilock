<?php

namespace ComposerFixed;

use Localheinz\Composer\Json\Normalizer\ComposerJsonNormalizer;

use Localheinz\Json\Normalizer\Json;


class ExtractVersions
{

    public static function extractFromFiles($composerJson, $composerLock)
    {
        if(!file_exists($composerJson) || !file_exists($composerLock)) {
            throw new \Exception("Could not open files");
        }
        $json = json_decode(file_get_contents($composerJson), true);
        if(json_last_error()) {
            throw new \Exception("Error decoding {$composerJson}: " . json_last_error_msg());
        }
        $lock = json_decode(file_get_contents($composerLock), true);
        if(json_last_error()) {
            throw new \Exception("Error decoding {$composerLock}: " . json_last_error_msg());
        }
        return self::formatJson(self::extract($json, $lock));
    }

    public static function extract(array $composerJson, array $composerLock)
    {
        //go through each of the composer.json and grab the packages, get their actual versions from the lock file
        $lockMap = self::getMappedLockDataFromFileArray($composerLock);
        foreach ($composerJson['require'] as $item => $reqPackage) {
            if (!empty($lockMap[$item]['version'])) {
                $composerJson['require'][$item] = $lockMap[$item]['version'];
            }
        }
        return $composerJson;
    }

    public static function packageToVersion($lockVersion)
    {
        if (substr($lockVersion['version'], 0, 4) == 'dev-') {
            return $lockVersion['version'] . '#' . $lockVersion['source']['reference'];
        }
        return $lockVersion['version'];
    }

    public static function formatJson(array $json)
    {
        $encoded = json_encode($json);
        $normalizer = new ComposerJsonNormalizer();
//        $json = Json::fromEncoded($encoded);
//        $normalizedJson = $normalizer->normalize($json);

        echo $encoded;//$normalizedJson->encoded();
    }

    public static function getMappedLockDataFromFileArray(array $lockFile)
    {
        $returnMap = [];
        foreach ($lockFile['packages'] as $package) {
            $returnMap[$package['name']] = $package;
        }

        return $returnMap;
    }
}