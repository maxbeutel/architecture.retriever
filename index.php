<?php


###
### Doctrine
###

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;

$lib = './lib/doctrine-orm/';
require $lib . 'Doctrine/Common/ClassLoader.php';

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\Common', $lib);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\DBAL', $lib);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\ORM', $lib);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Symfony', $lib);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('App', './');
$classLoader->register();

$cache = new \Doctrine\Common\Cache\ArrayCache;

$config = new Configuration();
$config->setMetadataCacheImpl($cache);
$driverImpl = $config->newDefaultAnnotationDriver('./App');
$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);
$config->setProxyDir('./App/Proxies');
$config->setProxyNamespace('App\Proxies');
$config->setAutoGenerateProxyClasses(true);

$connectionOptions = array(
    'driver'    => 'pdo_mysql',
    'host'      => 'localhost',
    'user'      => 'root',
    'password'  => 'password',
    'dbname'    => 'architecture_retriever_db',
);



$entityManager = EntityManager::create($connectionOptions, $config);

###
### Redis
###

spl_autoload_register(function($class) {
    $file = './lib/predis/lib/'.strtr($class, '\\', '/').'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
});

$redis = new Predis\Client($single_server = array(
    'host'  => '127.0.0.1',
    'port'  => 6379,
));


###
### Register Retriever (could be done via DI container!)
###

use App\Users\Domain\Relation;
use App\Users\Domain\Retriever\AddressRetriever;
use App\Users\Services\LoginService;

$relation = new Relation();
$relation->registerRetriever(new AddressRetriever($redis));


###
### Example Client Code
###

$userId = 89;

$service = new LoginService($entityManager, $redis);
$user = $service->doLogin($userId);


print $user->getName();
print '<br>';
print $user->lookup(Relation::address())->count();

