<?php

namespace Drupal\twitter_embed;

/**
 * Interface TwitterWidgetInterface.
 */
interface TwitterWidgetInterface {

  const USERNAME_MAX_LENGTH = 50;

  /**
   * Get all available settings for a widget.
   *
   * @return array
   *   List of settings.
   */
  public function getAvailableSettings();

  /**
   * Get default settings for a widget.
   *
   * @return array
   *   List of settings.
   */
  public static function getDefaultSettings();

  /**
   * Get the settings form for a widget.
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
  public function getSettingsForm(array $configuration);

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
