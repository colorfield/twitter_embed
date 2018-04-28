<?php

namespace Drupal\twitter_embed\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\twitter_embed\TwitterWidgetInterface;

/**
 * Provides a 'TwitterTimelineBlock' block.
 *
 * @Block(
 *  id = "twitter_embed_timeline",
 *  admin_label = @Translation("Twitter Timeline"),
 * )
 */
class TwitterTimelineBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\twitter_embed\TwitterWidgetInterface definition.
   *
   * @var \Drupal\twitter_embed\TwitterWidgetInterface
   */
  protected $twitterWidget;

  /**
   * Constructs a new TwitterTimelineBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    TwitterWidgetInterface $twitter_widget
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->twitterWidget = $twitter_widget;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('twitter_embed.widget')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    // @todo get values from $this->twitterWidget->getTimelineAvailableSettings()
    return [
      'display_style' => 'timeline',
      'type' => 'profile',
    // @todo default = auto
      'width' => 0,
      'height' => 600,
      'link_color' => '#2b7bb9',
      'theme' => 'light',
      'tweet_limit' => 0,
      'show_replies' => FALSE,
      'chrome' => NULL,
      'aria_polite' => 'polite',
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#default_value' => $this->configuration['username'],
      '#required' => TRUE,
      '#field_prefix' => '@',
      '#maxlength' => 50,
      '#size' => 50,
    ];
    $form['type'] = [
      '#type' => 'radios',
      '#title' => $this->t('Type'),
      '#options' => [
        'profile' => $this->t('Profile'),
        'list' => $this->t('List'),
        'collection' => $this->t('Collection'),
        'likes' => $this->t('Likes'),
      ],
      '#default_value' => $this->configuration['type'],
      '#required' => TRUE,
    ];
    // @todo use states depending on selected type
    $form['type_value'] = [
      '#type' => 'textfield',
      // @todo set the label depending on the selected type
      '#title' => $this->t('Type value'),
      '#default_value' => $this->configuration['type_value'],
      '#maxlength' => 128,
      '#size' => 64,
    ];
    // @todo styles are depending on type, use the service for that
    $form['display_style'] = [
      '#type' => 'radios',
      '#title' => $this->t('Display style'),
      '#options' => ['timeline' => $this->t('Timeline (list)'), 'grid' => $this->t('Grid')],
      '#default_value' => $this->configuration['display_style'],
      '#required' => TRUE,
    ];

    $form['display_options'] = [
      '#type' => 'details',
      '#title' => $this->t('Display options'),
      '#open' => FALSE,
    ];
    $form['display_options']['theme'] = [
      '#type' => 'radios',
      '#title' => $this->t('Theme'),
      '#description' => $this->t('Display light text on a dark background'),
      '#options' => ['light' => $this->t('Light'), 'dark' => $this->t('Dark')],
      '#default_value' => $this->configuration['theme'],
      '#required' => TRUE,
    ];
    $form['display_options']['chrome'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Chrome'),
      '#options' => [
        'noheader' => $this->t('No header'),
        'nofooter' => $this->t('No footer'),
        'noborders' => $this->t('No borders'),
        'transparent' => $this->t('Transparent'),
        'noscrollbar' => $this->t('No scrollbar'),
      ],
      '#default_value' => $this->configuration['chrome'],
    ];
    $form['display_options']['width'] = [
      '#type' => 'number',
      '#title' => $this->t('Width'),
      '#default_value' => $this->configuration['width'],
      '#field_suffix' => 'px',
    ];
    $form['display_options']['height'] = [
      '#type' => 'number',
      '#title' => $this->t('Height'),
      '#default_value' => $this->configuration['height'],
      '#field_suffix' => 'px',
    ];
    $form['display_options']['link_color'] = [
      '#type' => 'color',
      '#title' => $this->t('Link color'),
      '#default_value' => $this->configuration['link_color'],
    ];
    $form['display_options']['border_color'] = [
      '#type' => 'color',
      '#title' => $this->t('Border color'),
      '#default_value' => $this->configuration['border_color'],
      // @todo depends on the theme
    ];
    $form['display_options']['tweet_limit'] = [
      '#type' => 'number',
      '#title' => $this->t('Tweet limit'),
      '#description' => $this->t('The height parameter has no effect when a Tweet limit is set. Leave 0 for no limit.'),
      '#default_value' => $this->configuration['tweet_limit'],
      '#min' => 0,
      '#max' => 20,
    ];
    $form['display_options']['show_replies'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show replies'),
      '#default_value' => $this->configuration['show_replies'],
    ];
    $form['display_options']['aria_polite'] = [
      '#type' => 'radios',
      '#title' => $this->t('Aria polite'),
      '#description' => $this->t('Apply the specified aria-polite behavior.'),
      '#options' => [
        'polite' => $this->t('Polite'),
        'assertive' => $this->t('Assertive'),
        'rude' => $this->t('Rude'),
      ],
      '#default_value' => $this->configuration['aria_polite'],
    ];
    $form['display_options']['language'] = [
      '#type' => 'select',
      '#title' => $this->t('Language'),
      '#description' => $this->t('What language would you like to display this in?.'),
      '#options' => $this->twitterWidget->getAvailableLanguages(),
      '#default_value' => $this->configuration['language'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    foreach ($this->twitterWidget->getTimelineAvailableSettings() as $key => $setting) {
      // @todo use recursivity to handle nested arrays
      // @todo could not fit with some values (checkboxes)
      if (is_array($setting)) {
        foreach ($setting as $childKey => $childSetting) {
          $this->configuration[$childKey] = $form_state->getValue([$key, $childKey]);
        }
      }
      else {
        $this->configuration[$key] = $form_state->getValue($key);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return $this->twitterWidget->getWidget($this->configuration);
  }

}
