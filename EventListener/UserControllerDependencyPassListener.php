<?php
namespace Ihsan\SimpleAdminBundle\EventListener;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Ihsan\SimpleAdminBundle\Controller\UserController;

final class UserControllerDependencyPassListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (! is_array($controller)) {

            return;
        }

        $controller = $controller[0];

        if (! $controller instanceof UserController) {

            return;
        }

        $controller->setFormClass($this->container->getParameter('ihsan.simple_admin.security.user_form'));
        $controller->setEntityClass($this->container->getParameter('ihsan.simple_admin.security.user_entity'));
    }
}
