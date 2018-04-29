<?php

namespace Drupal\twitter_embed\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\twitter_embed\TwitterTimelineWidget;
use Drupal\twitter_embed\TwitterWidget;

/**
 * Plugin implementation of the 'twitter_timeline_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "twitter_timeline_formatter",
 *   label = @Translation("Twitter timeline"),
 *   field_types = {
 *     "twitter_embed_field"
 *   }
 * )
 */
class TwitterTimelineFormatter extends TwitterFormatterBase {

  /**
   * Constructs a TwitterTimelineFormatter.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings) {
    // @todo dependency injection
    $this->twitterWidget = \Drupal::service('twitter_embed.timeline_widget');
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return TwitterTimelineWidget::getDefaultSettings()
    + parent::defaultSettings();
  }

}
