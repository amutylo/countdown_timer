<?php
namespace Drupal\creation_countdown\Plugin\Field\FieldFormatter;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\datetime\Plugin\Field\FieldFormatter\DateTimeDefaultFormatter;

/**
 * Plugin implementation of the 'Default' formatter for 'countdown' field.
 *
 * @FieldFormatter(
 *   id = "countdown_default",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "countdown"
 *   }
 * )
 */
class CountDownDefaultFormatter extends DateTimeDefaultFormatter{
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        'weeks' => 1,
        'days' => 1,
        'hours' => 1,
        'minutes' => 1,
        'seconds' => 1
      ] + parent::defaultSettings();
  }
  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    //TODO:: Add display Days, hours, minutes, seconds
    $form = parent::settingsForm($form, $form_state);
    unset($form["format_type"]);
    $form['weeks'] = [
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('weeks'),
      '#title' => $this->t('weeks')
    ];
    $form['days'] = [
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('days'),
      '#title' => $this->t('days')
    ];
    $form['hours'] = [
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('hours'),
      '#title' => $this->t('hours')
    ];
    $form['minutes'] = [
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('minutes'),
      '#title' => $this->t("minutes")
    ];
    $form['seconds'] = [
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('seconds'),
      '#title' => $this->t('seconds')
    ];
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $date = new DrupalDateTime();
    $summary[] = t('Format: @display', ['@display' => $this->formatDate($date)]);
    $summary[] = t('Show : ');
    $showWeeks = $this->getSetting('weeks') ? 'yes' : 'no';
    $summary[] = t('- weeks : ') . $showWeeks;
    $showDays = $this->getSetting('days') ? 'yes' : 'no';
    $summary[] = t('- days : ') . $showDays;
    $showHours = $this->getSetting('hours') ? 'yes' : 'no';
    $summary[] = t('- hours : ') . $showHours;
    $showMinutes = $this->getSetting('minutes') ? 'yes' : 'no';
    $summary[] = t('- minutes : ') . $showMinutes;
    $showSeconds = $this->getSetting('seconds') ? 'yes' : 'no';
    $summary[] = t('- seconds : ') . $showSeconds;
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  protected function formatDate($date) {
    $format_type = 'short';
    $timezone = $this->getSetting('timezone_override') ?: $date->getTimezone()->getName();
    return $this->dateFormatter->format($date->getTimestamp(), $format_type, '', $timezone != '' ? $timezone : NULL);
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);
    foreach($elements as $key => $elem) {
      $elements[$key]['#theme'] = 'countdown';
    }
    return $elements;
  }
}
