<?php
namespace Group;

return [
    'permissions' => [
        'acl_resources' => [
            Entity\GroupResource::class,
            Entity\GroupUser::class,
        ],
    ],
    'api_adapters' => [
        'invokables' => [
            'groups' => Api\Adapter\GroupAdapter::class,
        ],
    ],
    'entity_manager' => [
        'mapping_classes_paths' => [
            dirname(__DIR__) . '/src/Entity',
        ],
        'proxy_paths' => [
            dirname(__DIR__) . '/data/doctrine-proxies',
        ],
        'filters' => [
            'resource_visibility' => Db\Filter\ResourceVisibilityFilter::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    'csv_import' => [
        'mappings' => [
            'item_sets' => [
                Mapping\GroupMapping::class,
            ],
            'items' => [
                Mapping\GroupMapping::class,
            ],
            'media' => [
                Mapping\GroupMapping::class,
            ],
            'resources' => [
                Mapping\GroupMapping::class,
            ],
            'users' => [
                Mapping\GroupMapping::class,
            ],
        ],
        'automapping' => [
            'group' => [
                'name' => 'group',
                'value' => 1,
                'label' => 'Group',
                'class' => 'group-module',
            ],
        ],
        'user_settings' => [
            'csv_import_automap_user_list' => [
                'group' => 'group',
            ],
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'groupSelector' => View\Helper\GroupSelector::class,
        ],
        'factories' => [
            'groupCount' => Service\ViewHelper\GroupCountFactory::class,
        ],
    ],
    'form_elements' => [
        'invokables' => [
            Form\GroupForm::class => Form\GroupForm::class,
            Form\SearchForm::class => Form\SearchForm::class,
        ],
        'factories' => [
            Form\Element\GroupSelect::class => Service\Form\Element\GroupSelectFactory::class,
        ],
    ],
    'navigation' => [
        'AdminGlobal' => [
            [
                'label' => 'Groups', // @translate
                'class' => 'o-icon-users',
                'route' => 'admin/group',
                'controller' => 'group',
                'action' => 'browse',
                'resource' => Controller\Admin\GroupController::class,
                'privilege' => 'browse',
                'useRouteMatch' => true,
                'pages' => [
                    [
                        'label' => 'Groups', // @translate
                        'route' => 'admin/group',
                        'controller' => 'group',
                        'visible' => true,
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            Controller\Admin\GroupController::class => Controller\Admin\GroupController::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'applyGroups' => Service\ControllerPlugin\ApplyGroupsFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'group' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/group[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'Group\Controller\Admin',
                                'controller' => Controller\Admin\GroupController::class,
                                'action' => 'browse',
                            ],
                        ],
                    ],
                    'group-id' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/group/:id[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'Group\Controller\Admin',
                                'controller' => Controller\Admin\GroupController::class,
                                'action' => 'show',
                            ],
                        ],
                    ],
                    'group-name' => [
                        'type' => 'Segment',
                        'options' => [
                            // The action is required to avoid collision with admin/group.
                            // A validation is done in the adapter.
                            'route' => '/group/:name/:action',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'name' => '[^\d]+.*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'Group\Controller\Admin',
                                'controller' => Controller\Admin\GroupController::class,
                                'action' => 'show',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => dirname(__DIR__) . '/language',
                'pattern' => '%s.mo',
                'text_domain' => null,
            ],
        ],
    ],
    'js_translate_strings' => [
        'Request too long to process.', // @translate
    ],
    'group' => [
        'config' => [
            // Apply the groups of item sets to items and medias.
            'group_recursive_item_sets' => true,
            // Apply the item groups to medias. Implied and not taken in account
            // when `group_recursive_item_sets` is true.
            'group_recursive_items' => true,
        ],
    ],
];
