<?php

namespace Drupal\twitter_embed;

/**
 * Interface TwitterWidgetInterface.
 */
interface TwitterWidgetInterface {

  /**
   * Get all available settings for a timeline.
   *
   * @return array
   *   Array of settings.
   */
  public function getTimelineAvailableSettings();

  /**
   * Get all available languages.
   *
   * @return array
   *   Array of languages.
   */
  public function getAvailableLanguages();

  /**
   * Returns a Twitter widget depending on the configuration.
   *
   * @param array $settings
   *   List of selected configuration.
   *
   * @return array
   *   The Twitter widget as a render array.
   */
  public function getWidget(array $settings);

}
