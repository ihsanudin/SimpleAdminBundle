<?php
namespace Ihsan\SimpleAdminBundle\Menu;

/**
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: http://blog.khodam.org
 */

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Router;

class Builder
{
    /**
     * @var Symfony\Component\Routing\RouteCollection
     */
    protected $routeCollection;

    /**
     * @var Symfony\Component\Translation\TranslatorInterface
     */
    protected $translator;

    /**
     * @var string
     */
    protected $translationDomain;

    public function __construct(Router $router, ContainerInterface $container)
    {
        $this->routeCollection = $router->getRouteCollection();
        $this->translator = $container->get('translator');
        $this->translationDomain = $container->getParameter('ihsan.simple_admin.translation_domain');
    }

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'sidebar-menu'
            )
        ));

        $menu->addChild('Home', array(
            'route' => 'home',
            'label' => sprintf('<i class="fa fa-dashboard"></i> %s</a>', $this->translator->trans('menu.dashboard', array(), $this->translationDomain)),
            'extras' => array('safe_label' => true),
            'attributes' => array(
                'class' => 'treeview'
            )
        ));

        $menu->addChild('Profile', array(
            'uri' => '#',
            'label' => sprintf('<i class="fa fa-user"></i> %s<i class="fa fa-angle-double-left pull-right"></i></a>', $this->translator->trans('menu.profile', array(), $this->translationDomain)),
            'extras' => array('safe_label' => true),
            'attributes' => array(
                'class' => 'treeview'
            )
        ));
        $menu['Profile']->setChildrenAttribute('class', 'treeview-menu');

        $menu['Profile']->addChild('UserProfile', array(
            'label' => $this->translator->trans('menu.profile', array(), $this->translationDomain),
            'route' => 'ihsan_simpleadmin_index_profile',
            'attributes' => array(
                'class' => 'treeview'
            )
        ));

        $menu['Profile']->addChild('ChangePassword', array(
            'uri' => '#',
            'label' => $this->translator->trans('menu.user.change_password', array(), $this->translationDomain),
//            'route' => 'ihsan_simpleadmin_security_user_profile',
            'attributes' => array(
                'class' => 'treeview'
            )
        ));

        if ($this->routeCollection->get('ihsan_simpleadmin_security_user_new')) {
            $this->addUserMenu($menu);
        }

        return $menu;
    }

    protected function addUserMenu($menu)
    {
        $menu->addChild('User', array(
            'uri' => '#',
            'label' => sprintf('<i class="fa fa-shield"></i> %s<i class="fa fa-angle-double-left pull-right"></i></a>', $this->translator->trans('menu.user.title', array(), $this->translationDomain)),
            'extras' => array('safe_label' => true),
            'attributes' => array(
                'class' => 'treeview'
            )
        ));

        $menu['User']->setChildrenAttribute('class', 'treeview-menu');

        $menu['User']->addChild('Add', array(
            'label' => $this->translator->trans('menu.user.add', array(), $this->translationDomain),
            'route' => 'ihsan_simpleadmin_security_user_new',
            'attributes' => array(
                'class' => 'treeview'
            )
        ));

        $menu['User']->addChild('List', array(
            'label' => $this->translator->trans('menu.user.list', array(), $this->translationDomain),
            'route' => 'ihsan_simpleadmin_security_user_list',
            'attributes' => array(
                'class' => 'treeview'
            )
        ));
    }
}
