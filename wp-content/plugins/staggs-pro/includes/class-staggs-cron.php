<?php

/**
 * The product cron functions for the plugin.
 *
 * @link       https://staggs.app
 * @since      1.6.5
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 */

/**
 * The plugin cron functions
 *
 * @package    Staggs/pro
 * @subpackage Staggs/pro/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Staggs_Cron {

	public function __construct() {
		add_action( 'wp', array( $this, 'activate_staggs_cron' ) );
		add_action( 'staggs_cleanup_garbage_files', array( $this, 'staggs_run_garbage_collector' ) );
	}

	function activate_staggs_cron() {
		if ( ! staggs_get_theme_option( 'sgg_enable_garbage_collector' ) ) {
			return; // Garbage collector not active.
		}

		if ( ! wp_next_scheduled( 'staggs_cleanup_garbage_files' ) ) {
			wp_schedule_event( current_time( 'timestamp' ), 'hourly', 'staggs_cleanup_garbage_files');
		}
	}

	function staggs_run_garbage_collector() {
		$days = staggs_get_theme_option( 'sgg_garbage_collector_days' ) ?: 30;
		if ( ! is_numeric( $days ) ) {
			return;
		}

		$timecheck  = (int)$days*24*60*60;
		$upload_dir = wp_get_upload_dir();
		$base_dir   = $upload_dir['basedir'];
		$folderName = $base_dir . '/staggs';

		if (file_exists($folderName)) {
			foreach (new DirectoryIterator($folderName) as $fileInfo) {
				if ($fileInfo->isDot()) {
					continue;
				}

				if ('json' !== $fileInfo->getExtension()) {
					continue; // Only remove saved configuration JSON files.
				}
				
				if ($fileInfo->isFile() && time() - $fileInfo->getCTime() >= $timecheck) {
					unlink($fileInfo->getRealPath());
				}
			}
		}
	}
}
