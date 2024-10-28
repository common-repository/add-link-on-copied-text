<?php
/*
 * Plugin Name:     Add link on copied text
 * Version:         2.4.2
 * Text Domain:     add-link-on-copied-text
 * Plugin URI:      https://yrokiwp.ru
 * Description:    This simple plugin adds a link to the text copied from your site. It starts working immediately after installation and activation, but it also has a few simple optional settings for customization.
 * Author:          dmitrylitvinov
 * Author URI:     https://profiles.wordpress.org/dmitrylitvinov/
 *
 *
 * License:           GNU General Public License v3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


define('ALOCT_VERSION', '2.4.2');
define('ALOCT_PLUGIN_DIR', plugin_dir_path(__FILE__));
/*------------Страница админки*------------*/
if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
    require_once(ALOCT_PLUGIN_DIR . 'admin.php');
    add_action('init', array('AddLinkOnCopiesText', 'init'));
}
/*------------Страница админки------------*/




function add_link_yrokiwp_js() {
    $val = get_option( 'aloct_option' );
    if(isset( $val['text_before_link'])){ $text_before_link = $val['text_before_link'];}else{ $text_before_link= 'Read more here:';}
    if(isset( $val['number_indents'])){ $number_indents = $val['number_indents'];}else{ $number_indents=2;}
   $br = str_repeat('<br>', $number_indents);

    if(isset($val['only_home'])){
        if($val['only_home']==1){
            $url = "'".get_home_url()."'";
        }else{

            $url ='document.location.href';
        }
    }else{  $url ='document.location.href';}
echo "<script>
function MyCopyText() {
var target_text = window.getSelection(),
add_text = '".$br.$text_before_link." ' + ".$url.",
out_text = target_text + add_text,
fake = document.createElement('div');
fake.style.position = 'absolute';
fake.style.left = '-99999px';
document.body.appendChild(fake);
fake.innerHTML = out_text;
target_text.selectAllChildren(fake);
window.setTimeout(function() {
document.body.removeChild(fake);
}, 100);
}
document.addEventListener('copy', MyCopyText);
</script>";
}

add_action( 'wp_head', 'add_link_yrokiwp_js' );