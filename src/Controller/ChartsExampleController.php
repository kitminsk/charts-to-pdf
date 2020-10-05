<?php

namespace Drupal\charts_example\Controller;

use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\examples\Utility\DescriptionTemplateTrait;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for Hooks example description page.
 *
 * This class uses the DescriptionTemplateTrait to display text we put in the
 * templates/description.html.twig file.
 */
class ChartsExampleController extends ControllerBase {

  use DescriptionTemplateTrait;
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  protected function getModuleName() {
    return 'charts_example';
  }

  /**
   * Controller to handle POST request.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function action(Request $request) {
    $directory = 'public://pagepdfimport/';

    if (\Drupal::service('file_system')->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS)) {

      $filename = uniqid() . '.pdf';
      $uri = $directory. $filename;
      $file_data = $_POST['data'];
      $file_data = preg_replace('#^data:application/\w+;base64,#i', '', $file_data);
      $file_data = base64_decode($file_data);

      $success = 0;
      if ($file = file_save_data($file_data, $uri, FileSystemInterface::EXISTS_RENAME)) {
        $success = 1;
      }
      return new JsonResponse(['result' => $success]);
    }
  }

}
