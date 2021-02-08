<?php
/**
 * Post Preview class.
 *
 * @package headless-cms
 */

namespace Headless_CMS\Features\Inc;

use Headless_CMS\Features\Inc\Traits\Singleton;

/**
 * Class Preview
 */
class Preview
{
	
	use Singleton;
	
	/**
	 * Construct method.
	 */
	protected function __construct()
	{
		$this->setup_hooks();
	}
	
	/**
	 * To setup action/filter.
	 *
	 * @return void
	 */
	protected function setup_hooks()
	{
		
		/**
		 * Action
		 */
		add_action('preview_post_link', [$this, 'set_frontend_post_preview_link']);
		
	}
	
	/**
	 * Sets the customized post preview link for frontend application.
	 *
	 * @param string $link The WordPress preview link.
	 */
	public function set_frontend_post_preview_link($link)
	{
		
		$plugin_settings               = get_option('hcms_plugin_options');
		$is_custom_preview_link_active = is_array($plugin_settings) && !empty($plugin_settings['activate_preview']) ? $plugin_settings['activate_preview'] : false;
		$frontend_site_url             = is_array($plugin_settings) && !empty($plugin_settings['frontend_site_url']) ? $plugin_settings['frontend_site_url'] : '';
		
		if (!$is_custom_preview_link_active) {
			return $link;
		}
		
		$root_url = WP_DEBUG === true ? 'http://localhost:3000/' : $frontend_site_url;
		return sprintf('%1$s_preview/%2$d/%3$d', trailingslashit( $root_url ), get_the_ID(), wp_create_nonce('wp_rest'));
	}
	
}
