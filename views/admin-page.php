<div id="app"></div>

<?php if (preg_match("/(.*.local|.*.test|.*.loc|localhost|127.*.1:.*)/i", $_SERVER['HTTP_HOST'])): ?>
<!-- HMR Reloader -->
<script id="__bs_script__">
//<![CDATA[
document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.5'><\/script>".replace(
    "HOST", location.hostname));
//]]>
</script>
<?php endif;?>
