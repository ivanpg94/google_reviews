<?php

/**
 * @file
 * Contains \Drupal\google_reviews\Form\GoogleReviewsForm.
 */

namespace Drupal\google_reviews\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Routing;

class GoogleReviewsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'google_reviews_form';
  }
  protected function getEditableConfigNames()
  {
    return [
      'google_reviews.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
 //   $form = parent::buildForm($form, $form_state);
    $config = $this->config('google_reviews.settings');

    $form['overview'] = [
      '#markup' => t('Place your company specific information for your Google Customer Reviews here.'),
      '#prefix' => '<p><strong>',
      '#suffix' => '</strong></p>',
    ];
//google_reviews
    $form['enabled'] = array(
      '#title' => t('Enable Google Customer Reviews'),
      '#description' => t('When enabled, the Google Customer Reviews badge will be enabled, as well as order reviews'),
      '#type' => 'checkbox',
      '#default_value' => \Drupal::config('google_reviews.settings')->get('google_reviews_enabled'),
    );

    $form['merchant_settings'] = [
      '#title' => t('Merchant Information'),
      '#description' => t('Please retrieve this from the Google Merchant Account.'),
      '#type' => 'fieldset',
      '#collapsable' => TRUE,
      '#collapsed' => FALSE,
    ];

//merchand ID
    $form['merchant_settings']['merchant_id'] = [
      '#title' => t('Google Merchant ID'),
      '#description' => t('Place your Google Merchant ID here.'),
      '#type' => 'textfield',
      '#size' => '15',
      '#placeholder' => '123456789',
      '#required' => FALSE,
      '#default_value' => \Drupal::config('google_reviews.settings')->get('google_reviews_merchant_id'),
    ];
    $form['merchant_settings']['merchant_id_fr'] = [
      '#title' => t('Google Merchant ID for .fr domain'),
      '#description' => t('Place your Google Merchant ID here.'),
      '#type' => 'textfield',
      '#size' => '15',
      '#placeholder' => '123456789',
      '#required' => FALSE,
      '#default_value' => \Drupal::config('google_reviews.settings')->get('google_reviews_merchant_id_fr'),
    ];
    $form['merchant_settings']['merchant_id_pt'] = [
      '#title' => t('Google Merchant ID for .pt domain'),
      '#description' => t('Place your Google Merchant ID here.'),
      '#type' => 'textfield',
      '#size' => '15',
      '#placeholder' => '123456789',
      '#required' => FALSE,
      '#default_value' => \Drupal::config('google_reviews.settings')->get('google_reviews_merchant_id_pt'),
    ];
    $form['merchant_settings']['merchant_id_de'] = [
      '#title' => t('Google Merchant ID for .de domain'),
      '#description' => t('Place your Google Merchant ID here.'),
      '#type' => 'textfield',
      '#size' => '15',
      '#placeholder' => '123456789',
      '#required' => FALSE,
      '#default_value' => \Drupal::config('google_reviews.settings')->get('google_reviews_merchant_id_de'),
    ];
    $form['merchant_settings']['merchant_id_shop'] = [
      '#title' => t('Google Merchant ID for .shop domain'),
      '#description' => t('Place your Google Merchant ID here.'),
      '#type' => 'textfield',
      '#size' => '15',
      '#placeholder' => '123456789',
      '#required' => FALSE,
      '#default_value' => \Drupal::config('google_reviews.settings')->get('google_reviews_merchant_id_shop'),
    ];
    $form['badge_settings'] = [
      '#title' => t('Badge Information'),
      '#description' => t('Please retrieve this from the Google Customer Reviews integration setup page.'),
      '#type' => 'fieldset',
      '#collapsable' => TRUE,
      '#collapsed' => FALSE,
    ];

    $badge_position_options = [
      'BOTTOM_RIGHT' => t('Bottom Right'),
      'BOTTOM_LEFT' => t('Bottom Left'),
      'USER_DEFINED' => t('User Defined'),
    ];
//Badge Position
    $form['badge_settings']['badge_position'] = [
      '#title' => t('Badge Position'),
      '#description' => t('Where would you like your badge to be placed on your website.'),
      '#type' => 'select',
      '#options' => $badge_position_options,
      '#default_value' => \Drupal::config('google_reviews.settings')->get('google_reviews_badge_location'),
    ];

    $form['review_settings'] = [
      '#title' => t('Review Settings'),
      '#description' => t('See the "Integrate the survey opt-in module" page on Google to view these settings.'),
      '#type' => 'fieldset',
      '#collapsable' => TRUE,
      '#collapsed' => FALSE,
    ];

    $reviews_opt_in_style = [
      'CENTER_DIALOG' => t('Center Dialog: Displayed as a dialog box in the center of the view.'),
      'BOTTOM_RIGHT_DIALOG' => t('Bottom Right Dialog: Displayed as a dialog box at the bottom right of the view.'),
      'BOTTOM_LEFT_DIALOG' => t('Bottom Left Dialog: Displayed as a dialog box at the bottom left of the view.'),
      'TOP_RIGHT_DIALOG' => t('Top Right Dialog: Displayed as a dialog box at the top right of the view.'),
      'TOP_LEFT_DIALOG' => t('Top Left Dialog: Displayed as a dialog box at the top left of the view.'),
      'BOTTOM_TRAY' => t('Bottom Tray: Displayed in the bottom of the view.'),
    ];
//Opt in location
    $form['review_settings']['opt_in_location'] = [
      '#title' => t('Opt-In Location'),
      '#description' => t("Specifies how the opt-in module's dialog box is displayed."),
      '#type' => 'radios',
      '#options' => $reviews_opt_in_style,
      '#default_value' => \Drupal::config('google_reviews.settings')->get('google_reviews_opt_in_location'),
    ];
//estimated_shipping days
    $form['review_settings']['estimated_shipping_days'] = [
      '#title' => t('Estimated Shipping Days'),
      '#description' => t('By default, how many days after an order will the product deliver?'),
      '#type' => 'textfield',
      '#size' => '5',
      '#placeholder' => '14',
      '#required' => FALSE,
      '#default_value' => \Drupal::config('google_reviews.settings')->get('google_reviews_estimated_shipping_days'),
    ];
//estimated_shipping_days_exclude_weekends
     $form['review_settings']['estimated_shipping_days_exclude_weekends'] = array(
         '#title' => t('Exclude Weekends in Shipping Days'),
         '#description' => t('This will make your shipping estimate exclude Saturday and Sunday.'),
         '#type' => 'checkbox',
         '#default_value' => \Drupal::config('google_reviews.settings')->get('google_reviews_estimated_shipping_days_exclude_weekends'),
       );

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Save Settings'),
    ];
    return $form;

  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $google_reviews = $form_state->getValue('enabled');
    $merchant_id = $form_state->getValue('merchant_id');
    $badge_position = $form_state->getValue('badge_position');
    $opt_in_location = $form_state->getValue('opt_in_location');
    $estimated_shipping_days = $form_state->getValue('estimated_shipping_days');
    $estimated_shipping_days_exclude_weekends = $form_state->getValue('estimated_shipping_days_exclude_weekends');



    if (empty($merchant_id)) {
      $form_state->setErrorByName('merchant_id', $this->t('this field is required '));
    }
    if (empty($badge_position)) {
      $form_state->setErrorByName('badge_position', $this->t('this field is required '));
    }
    if (empty($opt_in_location)) {
      $form_state->setErrorByName('opt_in_location', $this->t('this field is required '));
    }
    if (empty($estimated_shipping_days)) {
      $form_state->setErrorByName('estimated_shipping_days', $this->t('this field is required '));
    }


    $merchant_id_validator = '/^[0-9]+/';
    $merchant_id = $form_state->getValue(['merchant_id']);

    // Validate Merchant ID to integers in a row with no spaces.
    if (!preg_match($merchant_id_validator, $merchant_id)) {
      $form_state->setErrorByName('merchant_id', t('Invalid Merchant ID, Please check your work.'));
    }

    // Validate Estimated Shipping Days is an integer of days.
    $estimated_shipping_days_validator = '/^[0-9]+/';
    $estimated_shipping_days = $form_state->getValue(['estimated_shipping_days']);

    if (!preg_match($estimated_shipping_days_validator, $estimated_shipping_days)) {
      $form_state->setErrorByName('estimated_shipping_days', t('Invalid Shipping Days, please use a number to add to the days from the order date.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRebuild(TRUE);

    // Save Commerce Google Trusted Store Variables.
    \Drupal::configFactory()->getEditable('google_reviews.settings')->set('google_reviews_enabled', $form_state->getValue(['enabled']))->save();
    \Drupal::configFactory()->getEditable('google_reviews.settings')->set('google_reviews_merchant_id', $form_state->getValue(['merchant_id']))->save();
    \Drupal::configFactory()->getEditable('google_reviews.settings')->set('google_reviews_merchant_id_fr', $form_state->getValue(['merchant_id_fr']))->save();
    \Drupal::configFactory()->getEditable('google_reviews.settings')->set('google_reviews_merchant_id_pt', $form_state->getValue(['merchant_id_pt']))->save();
    \Drupal::configFactory()->getEditable('google_reviews.settings')->set('google_reviews_merchant_id_de', $form_state->getValue(['merchant_id_de']))->save();
    \Drupal::configFactory()->getEditable('google_reviews.settings')->set('google_reviews_merchant_id_shop', $form_state->getValue(['merchant_id_shop']))->save();
    \Drupal::configFactory()->getEditable('google_reviews.settings')->set('google_reviews_badge_location', $form_state->getValue(['badge_position']))->save();
    \Drupal::configFactory()->getEditable('google_reviews.settings')->set('google_reviews_opt_in_location', $form_state->getValue(['opt_in_location']))->save();
    \Drupal::configFactory()->getEditable('google_reviews.settings')->set('google_reviews_estimated_shipping_days', $form_state->getValue(['estimated_shipping_days']))->save();
    \Drupal::configFactory()->getEditable('google_reviews.settings')->set('google_reviews_estimated_shipping_days_exclude_weekends', $form_state->getValue(['estimated_shipping_days_exclude_weekends']))->save();

 //   parent::submitForm($form, $form_state);

  }

}
?>
