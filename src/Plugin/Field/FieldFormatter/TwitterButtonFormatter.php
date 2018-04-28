<?php

namespace Drupal\twitter_embed\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\twitter_embed\TwitterWidget;

/**
 * Plugin implementation of the 'twitter_button_formatter' formatter.
 *
 * @todo refactor using a TwitterFormatterBase
 *
 * @FieldFormatter(
 *   id = "twitter_button_formatter",
 *   label = @Translation("Twitter button"),
 *   field_types = {
 *     "twitter_embed_field"
 *   }
 * )
 */
class TwitterButtonFormatter extends FormatterBase {

  /**
   * Drupal\twitter_embed\TwitterWidgetInterface definition.
   *
   * @var \Drupal\twitter_embed\TwitterWidgetInterface
   */
  protected $twitterWidget;

  /**
   * Constructs a TwitterButtonFormatter.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings) {
    // @todo dependency injection
    $this->twitterWidget = \Drupal::service('twitter_embed.widget');
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return TwitterWidget::getButtonDefaultSettings()
    + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return $this->twitterWidget->getButtonSettingsForm($this->getSettings())
    + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Display style: @display_style', [
      '@display_style' => $this->getSetting('display_style'),
    ]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $configuration = $this->getSettings();
      // @todo sanitize, remove @, ...
      $configuration['username'] = $this->viewValue($item);
      $elements[$delta] = $this->twitterWidget->getWidget($configuration);
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return nl2br(Html::escape($item->value));
  }

}
