<?php

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function legends_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

    $output .= '<div class="breadcrumb">' . implode(' › ', $breadcrumb) . '</div>';
    return $output;
  }
}

/**
 * Override or insert variables into the maintenance page template.
 */
function legends_preprocess_maintenance_page(&$vars) {
  // While markup for normal pages is split into page.tpl.php and html.tpl.php,
  // the markup for the maintenance page is all in the single
  // maintenance-page.tpl.php template. So, to have what's done in
  // legends_preprocess_html() also happen on the maintenance page, it has to be
  // called here.
  legends_preprocess_html($vars);
}

/**
 * Override or insert variables into the html template.
 */
function legends_preprocess_html(&$vars) {
  // Toggle fixed or fluid width.
  if (theme_get_setting('legends_width') == 'fluid') {
    $vars['classes_array'][] = 'fluid-width';
  }
  // Add conditional CSS for IE6.
  drupal_add_css(path_to_theme() . '/fix-ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lt IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
  
  $meta_ie_render_engine = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'content' =>  'IE=edge,chrome=1',
      'http-equiv' => 'X-UA-Compatible',
    )
  );
 
  // Add header meta tag for IE to head
  drupal_add_html_head($meta_ie_render_engine, 'meta_ie_render_engine');
}

/**
 * Override or insert variables into the html template.
 */
function legends_process_html(&$vars) {
  // Hook into color.module
  if (module_exists('color')) {
    _color_html_alter($vars);
  }
}

/**
 * Override or insert variables into the page template.
 */
function legends_preprocess_page(&$vars) {
  // Move secondary tabs into a separate variable.
  
  if (isset($vars['node'])) {
  // If the node type is "blog" the template suggestion will be "page--blog.tpl.php".
   $vars['theme_hook_suggestions'][] = 'page__'. str_replace('_', '--', $vars['node']->type);
  }
  
  $vars['tabs2'] = array(
    '#theme' => 'menu_local_tasks',
    '#secondary' => $vars['tabs']['#secondary'],
  );
  unset($vars['tabs']['#secondary']);

  if (isset($vars['main_menu'])) {
    $vars['primary_nav'] = theme('links__system_main_menu', array(
      'links' => $vars['main_menu'],
      'attributes' => array(
        'class' => array('links', 'inline', 'main-menu'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['primary_nav'] = FALSE;
  }
  if (isset($vars['secondary_menu'])) {
    $vars['secondary_nav'] = theme('links__system_secondary_menu', array(
      'links' => $vars['secondary_menu'],
      'attributes' => array(
        'class' => array('links', 'inline', 'secondary-menu'),
      ),
      'heading' => array(
        'text' => t('Secondary menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['secondary_nav'] = FALSE;
  }
	/* user login */
	$vars['page']['content']['system_main']['name']['#size'] = 40;
	$vars['page']['content']['system_main']['pass']['#size'] = 40;
	$vars['page']['content']['system_main']['mail']['#size'] = 40;
	$vars['page']['content']['system_main']['subject']['#size'] = 40;
	 
	/* user register */
	$vars['page']['content']['system_main']['account']['name']['#size'] = 40;
	$vars['page']['content']['system_main']['account']['mail']['#size'] = 40;
  // Prepare header.
  $site_fields = array();
  if (!empty($vars['site_name'])) {
    $site_fields[] = $vars['site_name'];
  }
  if (!empty($vars['site_slogan'])) {
    $site_fields[] = $vars['site_slogan'];
  }
  $vars['site_title'] = implode(' ', $site_fields);
  if (!empty($site_fields)) {
    $site_fields[0] = '<span>' . $site_fields[0] . '</span>';
  }
  $vars['site_html'] = implode(' ', $site_fields);

  // Set a variable for the site name title and logo alt attributes text.
  $slogan_text = $vars['site_slogan'];
  $site_name_text = $vars['site_name'];
  $vars['site_name_and_slogan'] = $site_name_text . ' ' . $slogan_text;
  
  
}

/**
 * Override or insert variables into the node template.
 */
function legends_preprocess_node(&$vars) {
  if ($vars['type'] == 'blog') {
    $vars['blog_created_day'] = date('d', $vars['created']);
    $vars['blog_created_month'] = date('M', $vars['created']);
  }
  if (isset($vars['node']->type)) {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['node']->type;
  }
}

/**
 * Override or insert variables into the comment template.
 */
function legends_preprocess_comment(&$vars) {
  $vars['submitted'] = $vars['created'] . ' — ' . $vars['author'];
}

/**
 * Override or insert variables into the block template.
 */
function legends_preprocess_block(&$vars) {
  $vars['title_attributes_array']['class'][] = 'title';
  $vars['classes_array'][] = 'clearfix';
}

/**
 * Override or insert variables into the page template.
 */
function legends_process_page(&$vars) {
  	// Hook into color.module
  	if (module_exists('color')) {
    	_color_page_alter($vars);
	}
	drupal_add_js(path_to_theme('legends') . '/js/gallery/jquery.mousewheel-3.0.6.pack.js');
  	drupal_add_js(path_to_theme('legends') . '/js/gallery/fancybox/jquery.fancybox.pack.js');
	drupal_add_css(path_to_theme('legends') . '/js/gallery/fancybox/jquery.fancybox.css');
}

/**
 * Override or insert variables into the region template.
 */
function legends_preprocess_region(&$vars) {
  if ($vars['region'] == 'header') {
    $vars['classes_array'][] = 'clearfix';
  }
}

function legends_get_suggestions($args, $base, $delimiter = '__') {

  // Build a list of suggested theme hooks or body classes in order of
  // specificity. One suggestion is made for every element of the current path,
  // though numeric elements are not carried to subsequent suggestions. For
  // example, for $base='page', http://www.example.com/node/1/edit would result
  // in the following suggestions and body classes:
  //
  // page__node              page-node
  // page__node__%           page-node-%
  // page__node__1           page-node-1
  // page__node__edit        page-node-edit

  $suggestions = array();
  $prefix = $base;
  foreach ($args as $arg) {
    // Remove slashes or null per SA-CORE-2009-003 and change - (hyphen) to _
    // (underscore).
    //
    // When we discover templates in @see drupal_find_theme_templates,
    // hyphens (-) are converted to underscores (_) before the theme hook
    // is registered. We do this because the hyphens used for delimiters
    // in hook suggestions cannot be used in the function names of the
    // associated preprocess functions. Any page templates designed to be used
    // on paths that contain a hyphen are also registered with these hyphens
    // converted to underscores so here we must convert any hyphens in path
    // arguments to underscores here before fetching theme hook suggestions
    // to ensure the templates are appropriately recognized.
    $arg = str_replace(array("/", "\\", "\0", '-'), array('', '', '', '_'), $arg);
    // The percent acts as a wildcard for numeric arguments since
    // asterisks are not valid filename characters on many filesystems.
    if (is_numeric($arg)) {
      $suggestions[] = $prefix . $delimiter . '%';
    }
    $suggestions[] = $prefix . $delimiter . $arg;
    if (!is_numeric($arg)) {
      $prefix .= $delimiter . $arg;
    }
  }
  if (drupal_is_front_page()) {
    // Front templates should be based on root only, not prefixed arguments.
    $suggestions[] = $base . $delimiter . 'front';
  }

  return $suggestions;
}

/*blog entry*/
function legends_preprocess_node_blog__entry(&$variables) {
  $variables['view_mode'] = $variables['elements']['#view_mode'];
  // Provide a distinct $teaser boolean.
  $variables['teaser'] = $variables['view_mode'] == 'teaser';
  $variables['node'] = $variables['elements']['#node'];
  $node = $variables['node'];

  $variables['date']      = format_date($node->created, 'blog');
  $variables['name']      = theme('username', array('account' => $node));

  $uri = entity_uri('node', $node);
  $variables['node_url']  = url($uri['path'], $uri['options']);
  $variables['title']     = check_plain($node->title);
  $variables['page']      = $variables['view_mode'] == 'full' && node_is_page($node);

  // Flatten the node object's member fields.
  $variables = array_merge((array) $node, $variables);

  // Helpful $content variable for templates.
  $variables += array('content' => array());
  foreach (element_children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }

  // Make the field variables available with the appropriate language.
  field_attach_preprocess('node', $node, $variables['content'], $variables);

  // Display post information only on certain node types.
  if (variable_get('node_submitted_' . $node->type, TRUE)) {
    $variables['display_submitted'] = TRUE;
    $variables['submitted'] = t('Submitted by !username on !datetime', array('!username' => $variables['name'], '!datetime' => $variables['date']));
    $variables['user_picture'] = theme_get_setting('toggle_node_user_picture') ? theme('user_picture', array('account' => $node)) : '';
  }
  else {
    $variables['display_submitted'] = FALSE;
    $variables['submitted'] = '';
    $variables['user_picture'] = '';
  }

  // Gather node classes.
  $variables['classes_array'][] = drupal_html_class('node-' . $node->type);
  if ($variables['promote']) {
    $variables['classes_array'][] = 'node-promoted';
  }
  if ($variables['sticky']) {
    $variables['classes_array'][] = 'node-sticky';
  }
  if (!$variables['status']) {
    $variables['classes_array'][] = 'node-unpublished';
  }
  if ($variables['teaser']) {
    $variables['classes_array'][] = 'node-teaser';
  }
  if (isset($variables['preview'])) {
    $variables['classes_array'][] = 'node-preview';
  }
  // Clean up name so there are no underscores.
  $variables['theme_hook_suggestions'][] = 'node__' . $node->type;
  $variables['theme_hook_suggestions'][] = 'node__' . $node->nid;
}

function legends_form_user_register_form_alter(&$form, $form_state, $form_id) {

  if (!($form_id == 'user_register_form')) {
        return;
  }

  $form['account']['name']['#description'] = '';/*'Username has to be between 5-20 characters long and can only contain letters and numbers.';*/
  $form['account']['mail']['#description'] = '';/*'Please provide a valid e-mail address. The e-mail address is not made public';*/
  $form['actions']['submit'] = array(
     '#type' => 'submit',
	 '#name' => 'create',
     '#value' => t('Create new account'));
}
function legends_link($variables) {
	$variables['options']['html'] = TRUE;
  return '<a href="' . check_plain(url($variables['path'], $variables['options'])) . '"' . drupal_attributes($variables['options']['attributes']) . '>' . ($variables['options']['html'] ? $variables['text'] : check_plain($variables['text'])) . '</a>';
}

function legends_panels_default_style_render_region($vars) {
  $output = '';
  $output .= implode('', $vars['panes']);
  return $output;
}

function legends_links__system_main_menu(&$vars) {
  foreach ($vars['links'] as &$link) {
    // do what you need here...
    $link['title'] = '<span>' . $link['title'] . '</span>';
    $link['html'] = TRUE;
  }
  return theme_links($vars);
}
function legends_preprocess_field(&$variables, $hook) {
  $element = $variables['element'];

  // There's some overhead in calling check_plain() so only call it if the label
  // variable is being displayed. Otherwise, set it to NULL to avoid PHP
  // warnings if a theme implementation accesses the variable even when it's
  // supposed to be hidden. If a theme implementation needs to print a hidden
  // label, it needs to supply a preprocess function that sets it to the
  // sanitized element title or whatever else is wanted in its place.
  $variables['label_hidden'] = ($element['#label_display'] == 'hidden');
  $variables['label'] = $variables['label_hidden'] ? NULL : check_plain($element['#title']);

  // We want other preprocess functions and the theme implementation to have
  // fast access to the field item render arrays. The item render array keys
  // (deltas) should always be a subset of the keys in #items, and looping on
  // those keys is faster than calling element_children() or looping on all keys
  // within $element, since that requires traversal of all element properties.
  $variables['items'] = array();
  foreach ($element['#items'] as $delta => $item) {
    if (!empty($element[$delta])) {
      $variables['items'][$delta] = $element[$delta];
    }
  }

  // Add default CSS classes. Since there can be many fields rendered on a page,
  // save some overhead by calling strtr() directly instead of
  // drupal_html_class().
  $variables['field_name_css'] = strtr($element['#field_name'], '_', '-');
  $variables['field_type_css'] = strtr($element['#field_type'], '_', '-');
  $variables['classes_array'] = array(
    'field',
    'field-name-' . $variables['field_name_css'],
    'field-type-' . $variables['field_type_css'],
    'field-label-' . $element['#label_display'],
  );
  // Add a "clearfix" class to the wrapper since we float the label and the
  // field items in field.css if the label is inline.
  if ($element['#label_display'] == 'inline') {
    $variables['classes_array'][] = 'clearfix';
  }

  // Add specific suggestions that can override the default implementation.
  $variables['theme_hook_suggestions'] = array(
    'field__' . $element['#field_type'],
    'field__' . $element['#field_name'],
    'field__' . $element['#bundle'],
    'field__' . $element['#field_name'] . '__' . $element['#bundle'],
  );
}