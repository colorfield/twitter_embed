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
    // @todo use states for options depending on selected type
    // @todo empty type dependent values on form submit
    // @todo set display style back to list if not collection
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
    $form['type_value'] = [
      '#type' => 'textfield',
      // @todo set the label depending on the selected type
      '#title' => t('Type value'),
      '#default_value' => $configuration['type_value'],
      '#description' => t("Applies to collection (collection id e.g. '539487832448843776') or list (list name e.g. 'national-parks')."),
      '#maxlength' => 128,
      '#size' => 64,
      '#states' => [
        'visible' => [
          ['input[name="settings[type]"]' => ['value' => 'list']],
          'or',
          ['input[name="settings[type]"]' => ['value' => 'collection']],
        ],
        'required' => [
          ['input[name="settings[type]"]' => ['value' => 'list']],
          'or',
          ['input[name="settings[type]"]' => ['value' => 'collection']],
        ],
      ],
    ];
    $form['display_style'] = [
      '#type' => 'radios',
      '#title' => t('Display style'),
      '#description' => t('Grid is available for collection only.'),
      '#options' => ['timeline' => t('Timeline (list)'), 'grid' => t('Grid')],
      '#default_value' => $configuration['display_style'],
      '#required' => TRUE,
      '#states' => [
        'visible' => [
          ['input[name="settings[type]"]' => ['value' => 'collection']],
        ],
      ],
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
      '#description' => t('Leave 0 for auto width.'),
      '#default_value' => $configuration['width'],
      '#field_suffix' => 'px',
    ];
    $form['display_options']['height'] = [
      '#type' => 'number',
      '#title' => t('Height'),
      '#default_value' => $configuration['height'],
      '#field_suffix' => 'px',
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
  public function getButtonAvailableSettings() {
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
  public static function getButtonDefaultSettings() {
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
  public function getButtonSettingsForm(array $configuration) {
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
    $uri = 'https://twitter.com/' . $configuration['username'];
    // @todo refactor 'display_style' used for Button instead of 'type'
    // @todo complete configuration
    switch ($configuration['type']) {
      case 'list':
        $uri .= '/lists/' . $configuration['type_value'];
        break;

      case 'collection':
        $uri .= '/timelines/' . $configuration['type_value'];
        break;

      case 'likes':
        $uri .= '/likes';
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
    // Common data -ttributes.
    // @todo review common data-attributes
    $result['class'] = ['twitter-' . $configuration['display_style']];
    if (!empty($configuration['language'])) {
      $result['lang'] = $configuration['language'];
    }

    // @todo complete data-attribute list and check conditions depending on the type
    // Timeline specific data-attributes
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

    // Button specific data-attributes.
    if ($configuration['hide_username']) {
      $result['data-show-screen-name'] = 'false';
    }
    if ($configuration['hide_followers_count']) {
      $result['data-show-count'] = 'false';
    }
    if (!empty($configuration['size'])) {
      $result['data-size'] = 'large';
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function setDependentConfiguration(array &$configuration) {
    // @todo these rules should be used in form validation
    // Empty the type_value when unnecessary.
    if (!in_array($configuration['type'], ['list', 'collection'])) {
      $configuration['type_value'] = '';
    }
    // The grid display_style is available for collection type only.
    if ($configuration['type'] !== 'collection') {
      $configuration['display_style'] = 'timeline';
    }
  }

}
