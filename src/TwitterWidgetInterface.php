<?php

namespace Drupal\twitter_embed;

/**
 * Interface TwitterWidgetInterface.
 */
interface TwitterWidgetInterface {

  const USERNAME_MAX_LENGTH = 50;

  /**
   * Get all available settings for a timeline.
   *
   * @return array
   *   List of settings.
   */
  public function getTimelineAvailableSettings();

  /**
   * Get default settings for a timeline.
   *
   * @return array
   *   List of settings.
   */
  public static function getTimelineDefaultSettings();

  /**
   * Get the settings form for a timeline.
   *
   * It allows the sharing of the configuration among.
   * Block configuration and FieldFormatter configuration.
   *
   * @param array $configuration
   *   List of selected configuration.
   *
   * @return array
   *   The settings form.
   */
  public function getTimelineSettingsForm(array $configuration);

  /**
   * Get all available settings for a button.
   *
   * @return array
   *   List of settings.
   */
  public function getButtonAvailableSettings();

  /**
   * Get default settings for a button.
   *
   * @return array
   *   List of settings.
   */
  public static function getButtonDefaultSettings();

  /**
   * Get the settings form for a button.
   *
   * It allows the sharing of the configuration among.
   * Block configuration and FieldFormatter configuration.
   *
   * @param array $configuration
   *   List of selected configuration.
   *
   * @return array
   *   The settings form.
   */
  public function getButtonSettingsForm(array $configuration);

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
   * @param array $configuration
   *   List of selected configuration.
   *
   * @return array
   *   The Twitter widget as a render array.
   */
  public function getWidget(array $configuration);

  /**
   * Set the configuration state based on the chosen options.
   *
   * Some options are dependent to others, resets the options that
   * does not need values or set the default configuration to
   * avoid a configuration state that does not comply with the Twitter widgets.
   *
   * @param array $configuration
   *   List of selected configuration.
   */
  public function setDependentConfiguration(array &$configuration);

}
