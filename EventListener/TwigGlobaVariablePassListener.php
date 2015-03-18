<?php
namespace Ihsan\SimpleAdminBundle\EventListener;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Ihsan\SimpleAdminBundle\Controller\UserController;

final class TwigGlobaVariablePassListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $twig = $this->container->get('twig');
        $twig->addGlobal('title', $this->container->getParameter('ihsan.simple_admin.app_title'));
        $twig->addGlobal('date_time_format', $this->container->getParameter('ihsan.simple_admin.date_time_format'));
    }
}
