<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>
	
    <?php if ($main_menu || $secondary_menu): ?>
                <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'mobile-menu', 'class' => array('mobile-menu', ' mobile-grid-100', 'grid-parent', 'hide-on-desktop')), 'heading' => t(''))); ?>
    <?php endif; ?>
	<div class="grid-100 mobile-grid-100 grid-parent header">
		<div class="grid-20 mobile-grid-30 grid-parent logo">	
        	<a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home">The Legends Barbershop</a>
        </div>
        <div class="grid-80 mobile-grid-70 grid-parent menu-main">
            <ul class="menu-main-area-icons">
                    <li class="hide-on-desktop"><a href="#" id="mobile-menu-icon" class="menu" title="Mobile Menu" >Menu</a></li>
                    <li><a class="checkout" href="http://www.thelegendslondon.com/index.php?route=checkout/cart">Checkout</a></li>
                    <?php if(user_is_logged_in()){  ?>
                    <li><a href="/User/logout" class="user" title="Logout">User</a></li>
                    <? } else { ?>
                    <li><a href="<?php print $front_page; ?>User" class="user" title="Login">User</a></li>
                    <?php } ?>
            </ul>
            <?php if ($main_menu || $secondary_menu): ?>
                <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu', 'class' => array('menu-main-area', 'hide-on-mobile')), 'heading' => t(''))); ?>
                
            <?php endif; ?>
        </div>
        <?php print render($page['header']); ?>
    </div>
    <!-- CONTENT SECTIONS STARTS HERE -->
    <div class="grid-100 mobile-grid-100 grid-parent intro-box" style="background-image:url('<?php print $logo; ?>');">
    	<h1 class="grid-100 mobile-grid-100">
			"<?php if ($site_slogan): ?>
	        <?php print $site_slogan; ?>
        	<?php endif; ?>"
        </h1>
    </div>
     <div class="grid-100 mobile-grid-100 section page-node">
    	<div class="grid-100 mobile-grid-100 grid-parent grid-container">
    	<?php print $messages; ?>
        <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
        <a id="main-content"></a>
        <?php print render($title_prefix); ?>
        <?php if ($title): ?><h1><?php print $title; ?></h1><?php endif; ?>
        <?php print render($title_suffix); ?>
        <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
        <?php print render($page['help']); ?>
        <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
        <?php print render($page['content']); ?>
        <?php print $feed_icons; ?>
     	</div>
    </div>
    <?php if ($page['sidebar_first']): ?>
    <div id="sidebar-first" class="grid-100 mobile-grid-100 grid-parent">
      <?php print render($page['sidebar_first']); ?>
    </div>
    <?php endif; ?>
    <div class="grid-100 mobile-grid-100 footer">
        <div class="grid-100 mobile-grid-100 grid-parent grid-container">
            <div class="grid-100 mobile-grid-100 grid-parent no-para-padding-bottom">
              <?php if ($page['sidebar_second']): ?>
                  <?php print render($page['sidebar_second']); ?>
              <?php endif; ?>
             </div>
        </div>
    </div>

      
    <div class="grid-100 mobile-grid-100 footer-bottom">
        <ul class="grid-50 mobile-grid-100 social-media">
            <li><a class="email" title="Email: info@thelegendsbarbershop.com" href="mailto:info@thelegendsbarbershop.com">info@thelegendsbarbershop.com</a></li>
            <li><a class="facebook" title="Join us on Facebook" href="http://www.facebook.com/pages/The-Legends-Barber-Shop/251425724845">Facebook</a></li>
            <li><a class="twitter" title="Follow us on Twitter" href="https://twitter.com/The_Legends_">Twitter</a></li>
            <li><a class="youtube" title="Go to our YouTube channel" href="http://www.youtube.com/watch?feature=player_embedded&v=_d8TuY9_Y1E">Youtube</a></li>						
            <li><a class="tumblr" title="Join us on Tumblr" href="http://thelegendsbarbershop.tumblr.com/">Tumblr</a></li>
            <li><a class="instagram" title="Follow us on Instagram" href="http://instagram.com/thelegendsbarbers">Instagram</a></li>
            <li><a class="yelp" title="Follow us on Yelp" href="http://www.yelp.co.uk/biz/the-legends-barber-shop-london">Yelp</a></li>
		</ul>
    	<div class="grid-50 mobile-grid-100"><p><?php echo date("Y"); ?> &copy; The Legends Barbershop - Theme by Juliusz Kwiatkowski @ <a href="http://www.enderstudio.com/" target="blank">www.enderstudio.com</a>. Powered by <a href="https://www.drupal.org">Drupal</a></p></div>
    </div>  
    <!-- ENDS NEW-->