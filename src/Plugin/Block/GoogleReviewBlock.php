<?php

namespace Drupal\google_reviews\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a google block.
 *
 * @Block(
 *
id = "google_review_block",
 *
admin_label = @Translation("Google Review Block")
 * )
 */

class GoogleReviewBlock extends BlockBase implements BlockPluginInterface
{
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    $base_url = \Drupal::request()->getSchemeAndHttpHost();
    $is_fr = substr($base_url, -3);
    $is_pt = substr($base_url, -3);
    $is_de = substr($base_url, -3);
    $is_shop = substr($base_url, -5);
    $default_config = \Drupal::config('google_review.settings');
    if($is_fr == ".fr"){
      $merchant = $default_config->get('merchand_id');
    }/*elseif($is_pt ==".pt"){
      $merchant = $default_config->get('merchant_id_pt');
    }elseif($is_de ==".de"){
      $merchant = $default_config->get('merchant_id_de');
    }elseif($is_shop ==".shop"){
      $merchant = $default_config->get('merchant_id_shop');
    }*/else{
      $merchant = $default_config->get('merchant_id_fr');
    }
  return [
  'google_review' => $default_config->get('google_review'),
  'merchand_id' => $merchant,
  'badge_position' => $default_config->get('badge_position'),
  'opt_in_location' => $default_config->get('opt_in_location'),
  'estimated_shipping_days' => $default_config->get('estimated_shipping_days'),
  'estimated_shipping_days_exclude_weekends' => $default_config->get('estimated_shipping_days_exclude_weekends'),
  ];
}
  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $form['#attached']['library'][] = 'google_reviews/google_reviews';
    $renderable = [
      '#theme' => 'block--google-reviews',
      '#test_var' => 'test variable',
    ];

    $config = $this->getConfiguration();

    return
      /*array(
      '#theme' => 'google_reviews',
      '#attached' => array(
        'library' => array(
          'google_reviews/google_reviews',
        ),
        'drupalSettings' => [
          'google_review' => $config['google_review'],
          'merchand_id' => $config['merchand_id'],
          'badge_position' => $config['badge_position'],
          'opt_in_location' => $config['opt_in_location'],
          'estimated_shipping_days' => $config['estimated_shipping_days'],
          'estimated_shipping_days_exclude_weekends' => $config['estimated_shipping_days_exclude_weekends'],
        ],
      ),
      */
      [
        $form, $renderable
      ];
//    );
  }
  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $form['google_review'] = [
      '#type' => 'textfield',
      '#title' => $this->t('google_review'),
      '#description' => $this->t('Width of your map '),
      '#default_value' => isset($config['google_review']) ? $config['google_review'] : '',
    ];
    $form['merchand_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('merchand_id'),
      '#description' => $this->t('Height of google your map '),
      '#default_value' => isset($config['merchand_id']) ? $config['merchand_id'] : '',
    ];
    $form['badge_position'] = [
      '#type' => 'textfield',
      '#title' => $this->t('badge position'),
      '#default_value' => isset($config['badge_position']) ? $config['badge_position'] : '',
    ];

    $form['opt_in_location'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Center Position'),
      '#placeholder' => "latitude,longitude",
      '#description' => $this->t('Use this link to get latitude and longitude <a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),
      '#default_value' => isset($config['opt_in_location']) ? $config['opt_in_location'] : '',
    ];


    $form['estimated_shipping_days'] = [
      '#type' => 'textarea',
      '#title' => $this->t('estimated_shipping_days'),
      '#placeholder' => "latitude,longitude|latitude,longitude",
      '#description' => $this->t('Use | to separate markers. <br> Use this link to get latitude and longitude <a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),
      '#default_value' => isset($config['estimated_shipping_days']) ? $config['estimated_shipping_days'] : '',
    ];
    $form['estimated_shipping_days_exclude_weekends'] = [
      '#type' => 'textarea',
      '#title' => $this->t('estimated_shipping_days'),
      '#description' => $this->t('Use | to separate markers. <br> Use this link to get latitude and longitude <a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),
      '#default_value' => isset($config['estimated_shipping_days_exclude_weekends']) ? $config['estimated_shipping_days_exclude_weekends'] : '',
    ];
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['google_review'] = $values['google_review'];
    $this->configuration['merchand_id'] = $values['merchand_id'];
    $this->configuration['badge_position'] = $values['badge_position'];
    $this->configuration['opt_in_location'] = $values['opt_in_location'];
    $this->configuration['estimated_shipping_days'] = $values['estimated_shipping_days'];
    $this->configuration['estimated_shipping_days_exclude_weekends'] = $values['estimated_shipping_days_exclude_weekends'];
  }
}

