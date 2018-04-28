<?php

namespace Drupal\twitter_embed;

use Drupal\Core\Url;

/**
 * Class TwitterWidget.
 */
class TwitterWidget implements TwitterWidgetInterface {

  /**
   * {@inheritdoc}
   */
  public function getTimelineAvailableSettings() {
    return [
      'username' => '',
      'type' => 'profile',
      'type_value' => '',
      'display_style' => 'timeline',
      'display_options' => [
        'theme' => 'light',
        'chrome' => NULL,
        'width' => 0,
        'height' => 600,
        'link_color' => '#2b7bb9',
        'border_color' => '#000000',
        'tweet_limit' => 0,
        'show_replies' => FALSE,
        'aria_polite' => 'polite',
        'language' => '',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static final function getTimelineDefaultSettings() {
    // @todo flatten from getTimelineAvailableSettings()
    return [
      'username' => '',
      'type' => 'profile',
      'type_value' => '',
      'display_style' => 'timeline',
      'theme' => 'light',
      'chrome' => NULL,
      'width' => 0,
      'height' => 600,
      'link_color' => '#2b7bb9',
      'border_color' => '#000000',
      'tweet_limit' => 0,
      'show_replies' => FALSE,
      'aria_polite' => 'polite',
      'language' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getTimelineSettingsForm(array $configuration) {
    $form = [];
    $form['type'] = [
      '#type' => 'radios',
      '#title' => t('Type'),
      '#options' => [
        'profile' => t('Profile'),
        'list' => t('List'),
        'collection' => t('Collection'),
        'likes' => t('Likes'),
      ],
      '#default_value' => $configuration['type'],
      '#required' => TRUE,
    ];
    // @todo use states depending on selected type
    $form['type_value'] = [
      '#type' => 'textfield',
      // @todo set the label depending on the selected type
      '#title' => t('Type value'),
      '#default_value' => $configuration['type_value'],
      '#maxlength' => 128,
      '#size' => 64,
    ];
    // @todo styles are depending on type, use the service for that
    $form['display_style'] = [
      '#type' => 'radios',
      '#title' => t('Display style'),
      '#options' => ['timeline' => t('Timeline (list)'), 'grid' => t('Grid')],
      '#default_value' => $configuration['display_style'],
      '#required' => TRUE,
    ];

    $form['display_options'] = [
      '#type' => 'details',
      '#title' => t('Display options'),
      '#open' => FALSE,
    ];
    $form['display_options']['theme'] = [
      '#type' => 'radios',
      '#title' => t('Theme'),
      '#description' => t('Display light text on a dark background'),
      '#options' => ['light' => t('Light'), 'dark' => t('Dark')],
      '#default_value' => $configuration['theme'],
      '#required' => TRUE,
    ];
    $form['display_options']['chrome'] = [
      '#type' => 'checkboxes',
      '#title' => t('Chrome'),
      '#options' => [
        'noheader' => t('No header'),
        'nofooter' => t('No footer'),
        'noborders' => t('No borders'),
        'transparent' => t('Transparent'),
        'noscrollbar' => t('No scrollbar'),
      ],
      '#default_value' => $configuration['chrome'],
    ];
    $form['display_options']['width'] = [
      '#type' => 'number',
      '#title' => t('Width'),
      '#default_value' => $configuration['width'],
      '#field_suffix' => 'px',
    ];
    $form['display_options']['height'] = [
      '#type' => 'number',
      '#title' => t('Height'),
      '#default_value' => $configuration['height'],
      '#field_suffix' => 'px',
    ];
    $form['display_options']['link_color'] = [
      '#type' => 'color',
      '#title' => t('Link color'),
      '#default_value' => $configuration['link_color'],
    ];
    $form['display_options']['border_color'] = [
      '#type' => 'color',
      '#title' => t('Border color'),
      '#default_value' => $configuration['border_color'],
      // @todo depends on the theme
    ];
    $form['display_options']['tweet_limit'] = [
      '#type' => 'number',
      '#title' => t('Tweet limit'),
      '#description' => t('The height parameter has no effect when a Tweet limit is set. Leave 0 for no limit.'),
      '#default_value' => $configuration['tweet_limit'],
      '#min' => 0,
      '#max' => 20,
    ];
    $form['display_options']['show_replies'] = [
      '#type' => 'checkbox',
      '#title' => t('Show replies'),
      '#default_value' => $configuration['show_replies'],
    ];
    $form['display_options']['aria_polite'] = [
      '#type' => 'radios',
      '#title' => t('Aria polite'),
      '#description' => t('Apply the specified aria-polite behavior.'),
      '#options' => [
        'polite' => t('Polite'),
        'assertive' => t('Assertive'),
        'rude' => t('Rude'),
      ],
      '#default_value' => $configuration['aria_polite'],
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

  /**
   * {@inheritdoc}
   */
  public function getAvailableLanguages() {
    return [
      '' => t('Automatic'),
      'en' => t('English (default)'),
      'ar' => t('Arabic'),
      'bn' => t('Bengali'),
      'cs' => t('Czech'),
      'da' => t('Danish'),
      'de' => t('German'),
      'el' => t('Greek'),
      'es' => t('Spanish'),
      'fa' => t('Persian'),
      'fi' => t('Finnish'),
      'fil' => t('Filipino'),
      'fr' => t('French'),
      'he' => t('Hebrew'),
      'hi' => t('Hindi'),
      'hu' => t('Hungarian'),
      'id' => t('Indonesian'),
      'it' => t('Italian'),
      'ja' => t('Japanese'),
      'ko' => t('Korean'),
      'msa' => t('Malay'),
      'nl' => t('Dutch'),
      'no' => t('Norwegian'),
      'pl' => t('Polish'),
      'pt' => t('Portuguese'),
      'ro' => t('Romanian'),
      'ru' => t('Russian'),
      'sv' => t('Swedish'),
      'th' => t('Thai'),
      'tr' => t('Turkish'),
      'uk' => t('Ukrainian'),
      'ur' => t('Urdu'),
      'vi' => t('Vietnamese'),
      'zh-cn' => t('Chinese (Simplified)'),
      'zh-tw' => t('Chinese (Traditional)'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getWidget(array $configuration) {
    $build['twitter_widget'] = [
      '#type' => 'link',
      '#title' => $this->createLabel($configuration),
      '#url' => $this->createUrl($configuration),
      '#attributes' => $this->createAttributes($configuration),
      '#attached' => [
        'library' => ['twitter_embed/twitter_widgets'],
      ],
    ];
    return $build;
  }

  /**
   * Returns a Twitter Url depending on the configuration.
   *
   * @param array $configuration
   *   List of selected configuration.
   *
   * @return \Drupal\Core\Url
   *   The Twitter Url.
   */
  private function createUrl(array $configuration) {
    $uri = 'https://twitter.com/';
    // @todo complete configuration
    switch ($configuration['type']) {
      case 'profile':
        $uri .= $configuration['username'];
        break;

      case 'list':
        $uri .= $configuration['username'] . '/lists/' . $configuration['type_value'];
        break;

      case 'collection':
        $uri .= $configuration['username'] . '/timelines/' . $configuration['type_value'];
        break;

      case 'likes':
        $uri .= $configuration['username'] . '/likes';
        break;
    }
    return Url::fromUri($uri);
  }

  /**
   * Returns a label depending on the configuration.
   *
   * @param array $configuration
   *   List of selected configuration.
   *
   * @return string
   *   Label.
   */
  private function createLabel(array $configuration) {
    // @todo handle several cases from the configuration
    return t('Tweets by @@username', ['@username' => $configuration['username']]);
  }

  /**
   * Returns attributes depending on the configuration.
   *
   * @param array $configuration
   *   List of selected configuration.
   *
   * @return array
   *   List of attributes.
   */
  private function createAttributes(array $configuration) {
    $result = [];
    $result['class'] = ['twitter-' . $configuration['display_style']];

    // @todo complete data-attribute list and check conditions depending on the type
    if (!empty($configuration['theme'])) {
      $result['data-theme'] = $configuration['theme'];
    }
    if (!empty($configuration['chrome'])) {
      $options = array_keys(array_filter($configuration['chrome']));
      if (count($options)) {
        $result['data-chrome'] = implode(' ', $options);
      }
    }
    if (!empty($configuration['width'])) {
      $result['data-width'] = $configuration['width'];
    }
    if (!empty($configuration['height'])) {
      $result['data-height'] = $configuration['height'];
    }
    if (!empty($configuration['link_color'])) {
      $result['data-link-color'] = $configuration['link_color'];
    }
    if (!empty($configuration['border_color'])) {
      $result['data-border-color'] = $configuration['border_color'];
    }
    if (!empty($configuration['tweet_limit'])) {
      $result['data-tweet-limit'] = $configuration['tweet_limit'];
    }
    if (!empty($configuration['aria_polite'])) {
      $result['aria-polite'] = $configuration['aria_polite'];
    }
    if (!empty($configuration['language'])) {
      $result['lang'] = $configuration['language'];
    }
    return $result;
  }

}
