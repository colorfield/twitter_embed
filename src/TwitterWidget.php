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
      'username',
      'display_style',
      'theme',
      'chrome',
      'width',
      'height',
      'link_color',
      'border_color',
      'tweet_limit',
      'show_replies',
      'aria_polite',
      'language',
      'type',
      'type_value',
    ];
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
  public function getWidget(array $settings) {
    $build['twitter_widget'] = [
      '#type' => 'link',
      '#title' => $this->createLabelFromConfiguration($settings),
      '#url' => $this->createUrlFromConfiguration($settings),
      '#attributes' => $this->createAttributesFromConfiguration($settings),
      '#attached' => [
        'library' => ['twitter_embed/twitter_widgets'],
      ],
    ];
    return $build;
  }

  /**
   * Returns a Twitter Url depending on the configuration.
   *
   * @param array $settings
   *   List of selected configuration.
   *
   * @return \Drupal\Core\Url
   *   The Twitter Url.
   */
  private function createUrlFromConfiguration(array $settings) {
    $uri = 'https://twitter.com/';
    // @todo complete configuration
    switch ($settings['type']) {
      case 'profile':
        $uri .= $settings['username'];
        break;

      case 'list':
        $uri .= $settings['username'] . '/lists/' . $settings['type_value'];
        break;

      case 'collection':
        $uri .= $settings['username'] . '/timelines/' . $settings['type_value'];
        break;

      case 'likes':
        $uri .= $settings['username'] . '/likes';
        break;
    }
    return Url::fromUri($uri);
  }

  /**
   * Returns a label depending on the configuration.
   *
   * @param array $settings
   *   List of selected configuration.
   *
   * @return string
   *   Label.
   */
  private function createLabelFromConfiguration(array $settings) {
    // @todo handle several cases from the configuration
    return t('Tweets by @@username', ['@username' => $settings['username']]);
  }

  /**
   * Returns attributes depending on the configuration.
   *
   * @param array $settings
   *   List of selected configuration.
   *
   * @return array
   *   List of attributes.
   */
  private function createAttributesFromConfiguration(array $settings) {
    $result = [];
    $result['class'] = ['twitter-' . $settings['display_style']];

    // @todo complete data-attribute list and check conditions depending on the type
    if (!empty($settings['theme'])) {
      $result['data-theme'] = $settings['theme'];
    }
    if (!empty($settings['chrome'])) {
      $options = array_keys(array_filter($settings['chrome']));
      if (count($options)) {
        $result['data-chrome'] = implode(' ', $options);
      }
    }
    if (!empty($settings['width'])) {
      $result['data-width'] = $settings['width'];
    }
    if (!empty($settings['height'])) {
      $result['data-height'] = $settings['height'];
    }
    if (!empty($settings['link_color'])) {
      $result['data-link-color'] = $settings['link_color'];
    }
    if (!empty($settings['border_color'])) {
      $result['data-border-color'] = $settings['border_color'];
    }
    if (!empty($settings['tweet_limit'])) {
      $result['data-tweet-limit'] = $settings['tweet_limit'];
    }
    if (!empty($settings['aria_polite'])) {
      $result['aria-polite'] = $settings['aria_polite'];
    }
    if (!empty($settings['language'])) {
      $result['lang'] = $settings['language'];
    }
    return $result;
  }

}
