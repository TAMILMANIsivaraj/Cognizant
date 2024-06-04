<?php

namespace Drupal\mars_common\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\mars_common\LanguageHelper;
use Drupal\mars_common\ThemeConfiguratorParser;
use Drupal\mars_lighthouse\Traits\EntityBrowserFormTrait;
use Drupal\mars_media\MediaHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Provides a Campaign Banner component block.
 *
 * @Block(
 *   id = "campaign_banner_block",
 *   admin_label = @Translation("MARS: Campaign Banner block"),
 *   category = @Translation("Page components"),
 * )
 * @package Drupal\mars_common\Plugin\Block
 */

 class CampaignBannerBlock extends BlockBase implements ContainerFactoryPluginInterface {

    use EntityBrowserFormTrait;

    /**
    * Lighthouse entity browser image id.
    */
    const LIGHTHOUSE_ENTITY_BROWSER_IMAGE_ID = 'lighthouse_browser';

    /**
     * Key option image.
     */
    const KEY_OPTION_DEFAULT = 'default';
    
    /**
     * Key option image.
     */
    const KEY_OPTION_IMAGE = 'image';

  /**
   * The configFactory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Mars Media Helper service.
   *
   * @var \Drupal\mars_media\MediaHelper
   */
  protected $mediaHelper;

 /**
   * Language helper service.
   *
   * @var \Drupal\mars_common\LanguageHelper
   */
  private $languageHelper;

  /**
   * Theme configurator parser.
   *
   * @var \Drupal\mars_common\ThemeConfiguratorParser
   */
  protected $themeConfiguratorParser;

  /**
   * File url generator service.
   *
   * @var Drupal\Core\File\FileUrlGenerator
   */
  protected $fileUrlGenerator;

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;


  /**
   * {@inheritdoc}
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    ConfigFactoryInterface $config_factory,
    MediaHelper $media_helper,
    LanguageHelper $language_helper,
    ThemeConfiguratorParser $theme_configurator_parser,
    FileUrlGenerator $file_generator,
    EntityTypeManagerInterface $entityTypeManager
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->mediaHelper = $media_helper;
    $this->languageHelper = $language_helper;
    $this->themeConfigParser = $theme_config_parser;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('mars_media.media_helper'),
      $container->get('mars_common.language_helper'),
      $container->get('mars_common.theme_configurator_parser')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $build = [];
    return $build;
  }

   /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $config = $this->getConfiguration();
    $character_limit_config = $this->configFactory->getEditable('mars_common.character_limit_page');
    $form['element_id'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Element ID'),
        '#description' => $this->t('Use same element ID("ele_id")directly in Page Link to navigate within the page'),
        '#default_value' => $config['element_id'] ?? '',
      ];
    $form['enable_url'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Enable URL field'),
        '#default_value' => $config['enable_url'] ?? FALSE,
      ];

    $form['set_url'] = [
        '#type' => 'number',
        '#title' => $this->t('Enter the URL'),
        '#step' => 1,
        '#default_value' => '',
        '#description' => $this->t('Enter the Banner Url'),
        '#states' => [
          'visible' => [
            [':input[name="settings[enable_url]"]' => ['checked' => TRUE]],
          ],
        ],
      ];
      
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

  }
}