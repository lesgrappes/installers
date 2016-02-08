<?php
namespace Composer\Installers;

class RootInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'modules/{$name}/',
    );

    public function getInstallPath( \Composer\Package\PackageInterface $package, $frameworkType = '' )
    {
            $aExtra = $package->getExtra();

            $aModules = [];

            $sModuleFile = getcwd().'/app/configs/modules.php';
            if( file_exists($sModuleFile) )
            {
                $aModules = include $sModuleFile;
            }

            $aModules[$package->getName()] = [
                'className' => $aExtra['zeus']['className'],
                'path' => '../modules/'.$package->getName(),
            ];
            file_put_contents($sModuleFile,'<?php return '.var_export($aModules,true).';');


            return $this->templatePath($this->locations['module'], array('name' => $package->getName()) );
    }
}
