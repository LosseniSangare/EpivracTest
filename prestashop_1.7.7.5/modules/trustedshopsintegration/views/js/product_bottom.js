/**
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/
jQuery(document).ready(function() {
    if (typeof controller != 'undefined') {
        if (controller != 'product') {
            $('#ts_product_widget').insertAfter('.modal.quickview h1');
        } else {
            $('#ts_product_widget').insertAfter('h1[itemprop="name"]');
        }
    } else {
        $('#ts_product_widget').insertAfter('h1[itemprop="name"]');
    }
});
