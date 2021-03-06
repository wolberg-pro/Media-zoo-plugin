<?php
if (!defined('WPINC')) {
	die;
}
wp_localize_script( 'wp-api', 'wpApiSettings', array(
	'root' => esc_url_raw( rest_url() ),
	'nonce' => wp_create_nonce( 'wp_rest' )
) );
?>
<div id="app"></div>
<script>
	_wp_ASSEST_URL = '<?php echo MediaZoo_URL . 'views/dist'; ?>';
	_wp_API_URL = '<?php echo MediaZoo_URL; ?>';
	_wp_ROOT_URL = '<?php echo get_site_url() .'/'; ?>';
	_wp_nonce = '<?php echo wp_create_nonce( 'wp_rest' ) ?>';
</script>

<?php if (preg_match("/(.*.local|.*.test|.*.loc|localhost|127.*.1)/i", $_SERVER['HTTP_HOST'])): ?>
<!-- HMR Reloader -->
<script id="__bs_script__">
//<![CDATA[
document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.5'><\/script>".replace(
    "HOST", location.hostname));
//]]>
</script>
<?php endif;?>
