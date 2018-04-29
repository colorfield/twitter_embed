<?php

namespace Drupal\twitter_embed;

/**
 * Class TwitterButtonWidget.
 */
class TwitterButtonWidget extends TwitterWidget implements TwitterWidgetInterface {

  /**
   * {@inheritdoc}
   */
  public function getAvailableSettings() {
    return [
      'username' => '',
      'display_style' => 'follow-button',
      'display_options' => [
        'hide_username' => FALSE,
        'hide_followers_count' => FALSE,
        'size' => NULL,
        'theme' => 'light',
        'link_color' => '#2b7bb9',
        'border_color' => '#000000',
        'width' => 0,
        'height' => 600,
        'language' => '',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function getDefaultSettings() {
    // @todo flatten from getButtonAvailableSettings()
    return [
      'username' => '',
      'display_style' => 'follow-button',
      'hide_username' => FALSE,
      'hide_followers_count' => FALSE,
      'size' => NULL,
      'theme' => 'light',
      'link_color' => '#2b7bb9',
      'border_color' => '#000000',
      'width' => 0,
      'height' => 600,
      'language' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getSettingsForm(array $configuration) {
    $form = [];
    // @todo handle mention-button options
    $form['display_style'] = [
      '#type' => 'radios',
      '#title' => t('Display style'),
      '#options' => [
        'follow-button' => t('Follow Button'),
        'mention-button' => t('Mention Button'),
      ],
      '#default_value' => $configuration['display_style'],
      '#required' => TRUE,
    ];
    // @todo add display options
    $form['display_options']['hide_username'] = [
      '#type' => 'checkbox',
      '#title' => t('Hide username'),
      '#default_value' => $configuration['hide_username'],
    ];
    $form['display_options']['hide_followers_count'] = [
      '#type' => 'checkbox',
      '#title' => t('Hide followers count'),
      '#default_value' => $configuration['hide_followers_count'],
    ];
    $form['display_options']['size'] = [
      '#type' => 'checkbox',
      '#title' => t('Large button'),
      '#default_value' => $configuration['size'],
    ];
    $form['display_options']['language'] = [
      '#type' => 'select',
      '#title' => t('Language'),
      '#description' => t('What language would you like to display this in?.'),
      '#options' => $this->getAvailableLanguages(),
      '#default_value' => $configuration['language'],
    ];
    return $form;
  }

}
