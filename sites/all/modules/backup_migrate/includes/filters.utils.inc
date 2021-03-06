<?php
// $Id: filters.utils.inc,v 1.1.2.4 2009/08/22 19:58:13 ronan Exp $


/**
 * @file
 * A filter to run some basic utility functions. Basically any useful option not big enough to justify it's own class.
 */

/**
 * A filter to send a notification email on success or failure of backup.
 *
 * @ingroup backup_migrate_filters
 */
class backup_migrate_filter_utils extends backup_migrate_filter {
  var $saved_devel_query = NULL;

  /**
   * Get the default backup settings for this filter.
   */
  function backup_settings_default() {
    return array(
      'utils_disable_query_log' => TRUE,
      'utils_lock_tables' => FALSE,
      'utils_site_offline' => FALSE,
    );
  }

  /**
   * Get the default restore settings for this filter.
   */
  function restore_settings_default() {
    return array(
      'utils_disable_query_log' => TRUE,
      'utils_lock_tables' => FALSE,
      'utils_site_offline' => FALSE,
    );
  }

  /**
   * Get the form for the backup settings for this filter.
   */
  function backup_settings_form($settings) {
    $form = array();
    if (module_exists('devel') && variable_get('dev_query', 0)) {
      $form['database']['utils_disable_query_log'] = array(
        '#type' => 'checkbox',
        '#title' => t('Disable query log'),
        '#default_value' => !empty($settings['utils_disable_query_log']) ? $settings['utils_disable_query_log'] : NULL,
        '#description' => t('Disable the devel module\'s query logging during the backup operation. It will be enabled again after backup is complete. This is very highly recommended.'),
      );
    }
    $form['database']['utils_lock_tables'] = array(
      '#type' => 'checkbox',
      '#title' => t('Lock tables during backup'),
      '#default_value' => !empty($settings['utils_lock_tables']) ? $settings['utils_lock_tables'] : NULL,
      '#description' => t('This can help reduce data corruption, but will make your site unresponsive.'),
    );
    $form['advanced']['utils_site_offline'] = array(
      '#type' => 'checkbox',
      '#title' => t('Take site offline'),
      '#default_value' => !empty($settings['utils_lock_tables']) ? $settings['utils_lock_tables'] : NULL,
      '#description' => t('Take the site offline during backup and show a maintenance message. Site will be taken back online once the backup is complete.'),
    );
    $form['advanced']['utils_site_offline_message'] = array(
      '#type' => 'textarea',
      '#title' => t('Site off-line message'),
      '#default_value' => !empty($settings['utils_lock_tables']) ? $settings['utils_lock_tables'] : variable_get('site_offline_message', t('@site is currently under maintenance. We should be back shortly. Thank you for your patience.', array('@site' => variable_get('site_name', 'Drupal')))),
      '#description' => t('Message to show visitors when the site is in off-line mode.')
    );

    return $form;
  }

  /**
   * Get the form for the restore settings for this filter.
   */
  function restore_settings_form($settings) {
    $form = array();
    if (module_exists('devel') && variable_get('dev_query', 0)) {
      $form['advanced']['utils_disable_query_log'] = array(
        '#type' => 'checkbox',
        '#title' => t('Disable query log'),
        '#default_value' => @$settings['utils_disable_query_log'],
        '#description' => t('Disable the devel module\'s query logging during the restore operation. It will be enabled again after restore is complete. This is very highly recommended.'),
      );
    }
    $form['advanced']['utils_site_offline'] = array(
      '#type' => 'checkbox',
      '#title' => t('Take site offline'),
      '#default_value' => !empty($settings['utils_lock_tables']) ? $settings['utils_lock_tables'] : NULL,
      '#description' => t('Take the site offline during restore and show a maintenance message. Site will be taken back online once the restore is complete.'),
    );
    $form['advanced']['utils_site_offline_message'] = array(
      '#type' => 'textarea',
      '#title' => t('Site off-line message'),
      '#default_value' => !empty($settings['utils_lock_tables']) ? $settings['utils_lock_tables'] : variable_get('site_offline_message', t('@site is currently under maintenance. We should be back shortly. Thank you for your patience.', array('@site' => variable_get('site_name', 'Drupal')))),
      '#description' => t('Message to show visitors when the site is in off-line mode.')
    );
    return $form;
  }

  function pre_backup($source, $file, $settings) {
    $this->take_site_offline($settings);
    $this->disable_devel_query($settings);
    $this->lock_tables($settings);
  }

  function post_backup($source, $file, $settings) {
    $this->unlock_tables($settings);
    $this->enable_devel_query($settings);
    $this->take_site_online($settings);
  }

  function pre_restore($file, $settings) {
    $this->disable_devel_query($settings);
    $this->take_site_offline($settings);
  }

  function post_restore($file, $settings) {
    $this->enable_devel_query($settings);
    $this->take_site_online($settings);
  }

  /**
   * Disable devel query logging if it's active and the user has chosen to do so.
   */
  function disable_devel_query($settings) {
    $this->saved_devel_query = variable_get('dev_query', 0);
    if (module_exists('devel') && variable_get('dev_query', 0) && !empty($settings->filters['utils_disable_query_log'])) {
      variable_set('dev_query', 0);
    }
  }

  /**
   * Restore devel query to previous state.
   */
  function enable_devel_query($settings) {
    if (module_exists('devel')) {
      variable_set('dev_query', $this->saved_devel_query);
    }
  }

  /**
   * Lock the tables to be backed up if the lock setting is set.
   */
  function lock_tables($settings) {
    if ($settings->filters['utils_lock_tables']) {
      backup_migrate_db_lock_tables($settings->source, $settings);
    }
  }

  /**
   * Unlock any tables that have been locked.
   */
  function unlock_tables($settings) {
    if ($settings->filters['utils_lock_tables']) {
      db_unlock_tables();
    }
  }

  /**
   * Take the site offline if configured to do so.
   */
  function take_site_offline($settings) {
    // Save the current state of the site in case a restore overwrites it.
    $this->saved_site_offline = variable_get('site_offline', 0);
    if (@$settings->filters['utils_site_offline']) {
      $this->saved_site_offline_message = variable_get('site_offline_message', NULL);
      variable_set('site_offline', 1);
    }
  }

  /**
   * Take the site online again after backup or restore.
   */
  function take_site_online($settings) {
    // Take the site back off/online because the restored db may have changed that setting.
    variable_set('site_offline', $this->saved_site_offline);
    if ($settings->filters['utils_site_offline']) {
      variable_set('site_offline_message', $this->saved_site_offline_message);
    }
  }
}