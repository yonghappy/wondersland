<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Common' ) )
{
	/**
	 * Common functions for the plugin
	 * Independent from meta box/field classes
	 */
	class RWMB_Common
	{
		/**
		 * Do actions when class is loaded
		 *
		 * @return void
		 */
		static function on_load()
		{
		}

	
	}

	RWMB_Common::on_load();
}