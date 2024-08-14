<?php

declare(strict_types = 1);

namespace Drupal\sendgrid_api\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\key\KeyRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a deriver for sensors based on SendGrid API keys.
 *
 * @todo fix deps in https://www.drupal.org/project/drupal/issues/3001284.
 */
final class SendGridSensorDeriver extends DeriverBase implements ContainerDeriverInterface {

  use StringTranslationTrait;

  /**
   * SendGridSensorDeriver constructor.
   */
  public function __construct(
    protected KeyRepositoryInterface $keyRepository,
  ) {
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id): static {
    return new static(
      $container->get('key.repository')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition): array {
    foreach ($this->keyRepository->getKeysByType('sendgrid_api_key') as $key) {
      $id = $key->id();
      $this->derivatives[$id] = $base_plugin_definition;
      $this->derivatives[$id]['label'] = $this->t('SendGrid API Key: @key_name', [
        '@key_name' => $key->label(),
      ]);
    }
    return $this->derivatives;
  }

}
