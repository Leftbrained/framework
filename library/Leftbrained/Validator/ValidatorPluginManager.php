<?php
namespace Leftbrained\Validator;

use Zend\Validator\ValidatorPluginManager as BaseManager;
use Zend\ServiceManager\ConfigInterface;

class ValidatorPluginManager extends BaseManager
{
    public function __construct(ConfigInterface $configuration = null)
    {
        parent::__construct($configuration);
        $this->invokableClasses['keyvalues'] = 'Leftbrained\\Validator\\KeyValues';
        //$this->invokableClasses[''] = 'Leftbrained\\Validator\\';
    }
}