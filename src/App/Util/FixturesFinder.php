<?php
namespace App\Util;

use Hautelook\AliceBundle\Doctrine\Finder\FixturesFinder as BaseFixturesFinder;

class FixturesFinder extends BaseFixturesFinder
{
    /**
     * @var string
     */
    private $rootDir;

    /**
     * @param string $rootDir
     */
    public function setRootDir($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    protected function getLoadersPaths(array $bundles, $environment)
    {
        return [$this->rootDir.'/DataFixtures/ORM'];
    }
}
