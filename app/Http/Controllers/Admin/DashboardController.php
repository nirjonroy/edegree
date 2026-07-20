<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $pageTitle = 'Dashboard';

        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/admin/dashboard'],
            ['label' => 'Dashboard'],
        ];

        $stats = [
            [
                'value' => '150',
                'label' => 'New Orders',
                'theme' => 'primary',
                'icon' => 'bi-cart-fill',
                'link' => '#',
                'link_theme' => 'light',
            ],
            [
                'value' => '53',
                'suffix' => '%',
                'label' => 'Bounce Rate',
                'theme' => 'success',
                'icon' => 'bi-bar-chart-fill',
                'link' => '#',
                'link_theme' => 'light',
            ],
            [
                'value' => '44',
                'label' => 'User Registrations',
                'theme' => 'warning',
                'icon' => 'bi-person-plus-fill',
                'link' => '#',
                'link_theme' => 'dark',
            ],
            [
                'value' => '65',
                'label' => 'Unique Visitors',
                'theme' => 'danger',
                'icon' => 'bi-pie-chart-fill',
                'link' => '#',
                'link_theme' => 'light',
            ],
        ];

        $revenueChart = [
            'series' => [
                ['name' => 'Digital Goods', 'data' => [28, 48, 40, 19, 86, 27, 90]],
                ['name' => 'Electronics', 'data' => [65, 59, 80, 81, 56, 55, 40]],
            ],
            'categories' => [
                '2023-01-01',
                '2023-02-01',
                '2023-03-01',
                '2023-04-01',
                '2023-05-01',
                '2023-06-01',
                '2023-07-01',
            ],
            'colors' => ['#0d6efd', '#20c997'],
        ];

        $salesSparkline = [
            'series' => [
                ['name' => 'Sales', 'data' => [100, 120, 90, 110, 90, 130, 120]],
            ],
        ];

        $sidebarMenu = [
            [
                'label' => 'Dashboard',
                'icon' => 'bi-speedometer',
                'active' => true,
                'open' => true,
                'children' => [
                    ['label' => 'Dashboard v1', 'url' => '/admin/dashboard', 'active' => true],
                    ['label' => 'Dashboard v2', 'url' => '/admin/index2.html'],
                    ['label' => 'Dashboard v3', 'url' => '/admin/index3.html'],
                ],
            ],
            ['label' => 'Theme Generate', 'url' => '/admin/generate/theme.html', 'icon' => 'bi-palette'],
            [
                'label' => 'Widgets',
                'icon' => 'bi-box-seam-fill',
                'children' => [
                    ['label' => 'Small Box', 'url' => '/admin/widgets/small-box.html'],
                    ['label' => 'Info Box', 'url' => '/admin/widgets/info-box.html'],
                    ['label' => 'Cards', 'url' => '/admin/widgets/cards.html'],
                ],
            ],
            [
                'label' => 'Layout Options',
                'url' => '#',
                'icon' => 'bi-clipboard-fill',
                'badge' => '6',
                'children' => [
                    ['label' => 'Default Sidebar', 'url' => '/admin/layout/unfixed-sidebar.html'],
                    ['label' => 'Fixed Sidebar', 'url' => '/admin/layout/fixed-sidebar.html'],
                    ['label' => 'Fixed Header', 'url' => '/admin/layout/fixed-header.html'],
                    ['label' => 'Fixed Footer', 'url' => '/admin/layout/fixed-footer.html'],
                    ['label' => 'Fixed Complete', 'url' => '/admin/layout/fixed-complete.html'],
                    ['label' => 'Layout + Custom Area', 'url' => '/admin/layout/layout-custom-area.html'],
                    ['label' => 'Sidebar Mini', 'url' => '/admin/layout/sidebar-mini.html'],
                    ['label' => 'Sidebar Mini + Collapsed', 'url' => '/admin/layout/collapsed-sidebar.html'],
                    ['label' => 'Sidebar Mini + Logo Switch', 'url' => '/admin/layout/logo-switch.html'],
                    ['label' => 'Layout RTL', 'url' => '/admin/layout/layout-rtl.html'],
                ],
            ],
            [
                'label' => 'UI Elements',
                'url' => '#',
                'icon' => 'bi-tree-fill',
                'children' => [
                    ['label' => 'General', 'url' => '/admin/UI/general.html'],
                    ['label' => 'Icons', 'url' => '/admin/UI/icons.html'],
                    ['label' => 'Timeline', 'url' => '/admin/UI/timeline.html'],
                ],
            ],
            [
                'label' => 'Forms',
                'url' => '#',
                'icon' => 'bi-pencil-square',
                'children' => [
                    ['label' => 'General Elements', 'url' => '/admin/forms/general.html'],
                ],
            ],
            [
                'label' => 'Tables',
                'url' => '#',
                'icon' => 'bi-table',
                'children' => [
                    ['label' => 'Simple Tables', 'url' => '/admin/tables/simple.html'],
                ],
            ],
            ['header' => 'EXAMPLES'],
            [
                'label' => 'Auth',
                'url' => '#',
                'icon' => 'bi-box-arrow-in-right',
                'children' => [
                    [
                        'label' => 'Version 1',
                        'url' => '#',
                        'icon' => 'bi-box-arrow-in-right',
                        'children' => [
                            ['label' => 'Login', 'url' => '/admin/examples/login.html'],
                            ['label' => 'Register', 'url' => '/admin/examples/register.html'],
                        ],
                    ],
                    [
                        'label' => 'Version 2',
                        'url' => '#',
                        'icon' => 'bi-box-arrow-in-right',
                        'children' => [
                            ['label' => 'Login', 'url' => '/admin/examples/login-v2.html'],
                            ['label' => 'Register', 'url' => '/admin/examples/register-v2.html'],
                        ],
                    ],
                    ['label' => 'Lockscreen', 'url' => '/admin/examples/lockscreen.html'],
                ],
            ],
            ['header' => 'DOCUMENTATIONS'],
            ['label' => 'Installation', 'url' => '/admin/docs/introduction.html', 'icon' => 'bi-download'],
            ['label' => 'Layout', 'url' => '/admin/docs/layout.html', 'icon' => 'bi-grip-horizontal'],
            ['label' => 'Color Mode', 'url' => '/admin/docs/color-mode.html', 'icon' => 'bi-star-half'],
            [
                'label' => 'Components',
                'url' => '#',
                'icon' => 'bi-ui-checks-grid',
                'children' => [
                    ['label' => 'Main Header', 'url' => '/admin/docs/components/main-header.html'],
                    ['label' => 'Main Sidebar', 'url' => '/admin/docs/components/main-sidebar.html'],
                ],
            ],
            [
                'label' => 'Javascript',
                'url' => '#',
                'icon' => 'bi-filetype-js',
                'children' => [
                    ['label' => 'Treeview', 'url' => '/admin/docs/javascript/treeview.html'],
                ],
            ],
            ['label' => 'Browser Support', 'url' => '/admin/docs/browser-support.html', 'icon' => 'bi-browser-edge'],
            ['label' => 'How To Contribute', 'url' => '/admin/docs/how-to-contribute.html', 'icon' => 'bi-hand-thumbs-up-fill'],
            ['label' => 'FAQ', 'url' => '/admin/docs/faq.html', 'icon' => 'bi-question-circle-fill'],
            ['label' => 'License', 'url' => '/admin/docs/license.html', 'icon' => 'bi-patch-check-fill'],
            ['header' => 'MULTI LEVEL EXAMPLE'],
            ['label' => 'Level 1', 'url' => '#', 'icon' => 'bi-circle-fill'],
            [
                'label' => 'Level 1',
                'url' => '#',
                'icon' => 'bi-circle-fill',
                'children' => [
                    ['label' => 'Level 2', 'url' => '#'],
                    [
                        'label' => 'Level 2',
                        'url' => '#',
                        'children' => [
                            ['label' => 'Level 3', 'url' => '#', 'icon' => 'bi-record-circle-fill'],
                            ['label' => 'Level 3', 'url' => '#', 'icon' => 'bi-record-circle-fill'],
                            ['label' => 'Level 3', 'url' => '#', 'icon' => 'bi-record-circle-fill'],
                        ],
                    ],
                    ['label' => 'Level 2', 'url' => '#'],
                ],
            ],
            ['label' => 'Level 1', 'url' => '#', 'icon' => 'bi-circle-fill'],
            ['header' => 'LABELS'],
            ['label' => 'Important', 'url' => '#', 'icon' => 'bi-circle', 'icon_class' => 'text-danger', 'text_class' => 'text'],
            ['label' => 'Warning', 'url' => '#', 'icon' => 'bi-circle', 'icon_class' => 'text-warning'],
            ['label' => 'Informational', 'url' => '#', 'icon' => 'bi-circle', 'icon_class' => 'text-info'],
        ];

        $messages = [
            [
                'name' => 'Brad Diesel',
                'message' => 'Call me whenever you can...',
                'time' => '4 Hours Ago',
                'avatar' => '/admin/assets/img/user1-128x128.jpg',
                'star' => 'text-danger',
                'url' => '#',
            ],
            [
                'name' => 'John Pierce',
                'message' => 'I got your message bro',
                'time' => '4 Hours Ago',
                'avatar' => '/admin/assets/img/user8-128x128.jpg',
                'star' => 'text-secondary',
                'url' => '#',
            ],
            [
                'name' => 'Nora Silvester',
                'message' => 'The subject goes here',
                'time' => '4 Hours Ago',
                'avatar' => '/admin/assets/img/user3-128x128.jpg',
                'star' => 'text-warning',
                'url' => '#',
            ],
        ];

        $notifications = [
            ['icon' => 'bi-envelope', 'label' => '4 new messages', 'time' => '3 mins'],
            ['icon' => 'bi-people-fill', 'label' => '8 friend requests', 'time' => '12 hours'],
            ['icon' => 'bi-file-earmark-fill', 'label' => '3 new reports', 'time' => '2 days'],
        ];

        $notificationCount = 15;

        return view('admin.dashboard', compact(
            'pageTitle',
            'breadcrumbs',
            'stats',
            'revenueChart',
            'salesSparkline',
            'sidebarMenu',
            'messages',
            'notifications',
            'notificationCount'
        ));
    }
}
