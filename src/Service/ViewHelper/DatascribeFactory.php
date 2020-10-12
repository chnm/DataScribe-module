<?php
namespace Datascribe\Service\ViewHelper;

use Datascribe\ViewHelper\Datascribe;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class DatascribeFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new Datascribe($services);
    }
}
