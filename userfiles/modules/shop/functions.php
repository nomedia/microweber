<?php


event_bind('mw.admin', 'mw_add_admin_menu_buttons');
event_bind('mw.live_edit', 'mw_add_admin_menu_buttons');
function mw_add_admin_menu_buttons($params = false)
{
    if (get_option('shop_disabled', 'website') == 'y') {
        return;
    }


    $btn = array();
    $btn['content_type'] = 'product';
    $btn['title'] = _e("Product", true);
    $btn['class'] = 'mw-icon-product';
    mw()->module->ui('content.create.menu', $btn);


}

event_bind('mw.admin.dashboard.links', 'mw_print_admin_dashboard_orders_btn');
function mw_print_admin_dashboard_orders_btn()
{
    if (get_option('shop_disabled', 'website') == 'y') {
        return;
    }
    $admin_dashboard_btn = array();
    $admin_dashboard_btn['view'] = 'shop/action:orders';
    $admin_dashboard_btn['icon_class'] = 'mw-icon-shop';
    $notif_html = '';
    $notif_count = get_orders('count=1&order_status=[null]&is_completed=y');
    if ($notif_count > 0) {
        $notif_html = '<sup class="mw-notification-count">' . $notif_count . '</sup>';
    }
    $admin_dashboard_btn['text'] = _e("View Orders", true) . $notif_html;
    mw()->ui->admin_dashboard_menu($admin_dashboard_btn);
}

