<?php

namespace Drupal\twitter_embed\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\twitter_embed\TwitterButtonWidget;

/**
 * Plugin implementation of the 'twitter_button_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "twitter_button_formatter",
 *   label = @Translation("Twitter button"),
 *   field_types = {
 *     "twitter_embed_field"
 *   }
 * )
 */
class TwitterButtonFormatter extends TwitterFormatterBase {

  /**
   * Constructs a TwitterButtonFormatter.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings) {
    // @todo dependency injection
    $this->twitterWidget = \Drupal::service('twitter_embed.button_widget');
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return TwitterButtonWidget::getDefaultSettings()
    + parent::defaultSettings();
  }

}
