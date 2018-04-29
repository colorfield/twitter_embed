<?php

namespace Drupal\twitter_embed;

/**
 * Class TwitterTimelineWidget.
 */
class TwitterTimelineWidget extends TwitterWidget implements TwitterWidgetInterface {

  /**
   * {@inheritdoc}
   */
  public function getAvailableSettings() {
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
  public static final function getDefaultSettings() {
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
  public function getSettingsForm(array $configuration) {
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
      '#description' => t('Text and background colors.'),
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

}