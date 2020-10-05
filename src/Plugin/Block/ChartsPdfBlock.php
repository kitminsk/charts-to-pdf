<?php

namespace Drupal\charts_example\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Charts: create PDF.
 *
 * Drupal\Core\Block\BlockBase gives us a very useful set of basic functionality
 * for this configurable block. We can just fill in a few of the blanks with
 * defaultConfiguration(), blockForm(), blockSubmit(), and build().
 *
 * @Block(
 *   id = "charts_pdf_button",
 *   admin_label = @Translation("Charts: create PDF")
 * )
 */
class ChartsPdfBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'custom_path_to_pdf' => 'public://',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['custom_path_to_pdf'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Custom path to save PDF'),
      '#description' => $this->t('This text will appear in the example block.'),
      '#default_value' => $this->configuration['block_example_string'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   *
   * This method processes the blockForm() form fields when the block
   * configuration form is submitted.
   *
   * The blockValidate() method can be used to validate the form submission.
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['custom_path_to_pdf']
      = $form_state->getValue('custom_path_to_pdf');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $build['#convert_to_pdf'] = [
      '#type' => 'button',
      '#value' => $this->t('Send File'),
      '#attributes' => [
        'id' => 'charts-example-convert-to-pdf'
      ],
    ];

    $build['#convert_to_pdf_settings']
      = $this->configuration['custom_path_to_pdf'];

    $build['#theme'] = 'charts_pdf_button';
    $build['#attached'] = [
      'library' => [
        'charts_example/charts_example',
      ],
    ];

    return $build;
  }

}
