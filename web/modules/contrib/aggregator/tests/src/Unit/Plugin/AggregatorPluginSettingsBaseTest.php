<?php

namespace Drupal\Tests\aggregator\Unit\Plugin;

use Drupal\aggregator\Form\SettingsForm;
use Drupal\Core\Config\TypedConfigManagerInterface;
use Drupal\Core\Form\FormState;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Tests\UnitTestCase;

/**
 * Tests settings configuration of individual aggregator plugins.
 *
 * @group aggregator
 */
class AggregatorPluginSettingsBaseTest extends UnitTestCase {

  /**
   * The aggregator settings form object under test.
   *
   * @var \Drupal\aggregator\Form\SettingsForm
   */
  protected $settingsForm;

  /**
   * The stubbed config factory object.
   *
   * @var \PHPUnit\Framework\MockObject\MockBuilder
   */
  protected $configFactory;

  /**
   * The stubbed aggregator plugin managers array.
   *
   * @var array
   */
  protected $managers;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->configFactory = $this->getConfigFactoryStub(
      [
        'aggregator.settings' => [
          'processors' => ['aggregator_test'],
        ],
        'aggregator_test.settings' => [],
      ]
    );
    /** @var \Drupal\Core\Config\TypedConfigManagerInterface|\PHPUnit\Framework\MockObject\MockBuilder $typedConfigManager */
    $typedConfigManager = $this->createMock(TypedConfigManagerInterface::class);
    foreach (['fetcher', 'parser', 'processor'] as $type) {
      $this->managers[$type] = $this->getMockBuilder('Drupal\aggregator\Plugin\AggregatorPluginManager')
        ->disableOriginalConstructor()
        ->getMock();
      $this->managers[$type]->expects($this->once())
        ->method('getDefinitions')
        ->willReturn(['aggregator_test' => ['title' => '', 'description' => '']]);
    }

    /** @var \Drupal\Core\Messenger\MessengerInterface|\PHPUnit\Framework\MockObject\MockBuilder $messenger */
    $messenger = $this->createMock(MessengerInterface::class);
    $messenger->expects($this->any())->method('addMessage');

    $this->settingsForm = new SettingsForm(
      $this->configFactory,
      $typedConfigManager,
      $this->managers['fetcher'],
      $this->managers['parser'],
      $this->managers['processor'],
      $this->getStringTranslationStub()
    );
    $this->settingsForm->setMessenger($messenger);
  }

  /**
   * Tests for AggregatorPluginSettingsBase.
   *
   * Ensure that the settings form calls build, validate and submit methods on
   * plugins that extend AggregatorPluginSettingsBase.
   */
  public function testSettingsForm() {
    // Emulate a form state of a submitted form.
    $form_state = (new FormState())->setValues([
      'dummy_length' => '',
    ]);

    $test_processor = $this->getMockBuilder('Drupal\aggregator_test\Plugin\aggregator\processor\TestProcessor')
      ->onlyMethods(['buildConfigurationForm', 'validateConfigurationForm', 'submitConfigurationForm'])
      ->setConstructorArgs([[], 'aggregator_test', ['description' => ''], $this->configFactory])
      ->getMock();
    $test_processor->expects($this->once())
      ->method('buildConfigurationForm')
      ->with($this->anything(), $form_state)
      ->willReturnArgument(0);
    $test_processor->expects($this->once())
      ->method('validateConfigurationForm')
      ->with($this->anything(), $form_state);
    $test_processor->expects($this->once())
      ->method('submitConfigurationForm')
      ->with($this->anything(), $form_state);

    $this->managers['processor']->expects($this->once())
      ->method('createInstance')
      ->with($this->equalTo('aggregator_test'))
      ->willReturn($test_processor);

    $form = $this->settingsForm->buildForm([], $form_state);
    $this->settingsForm->validateForm($form, $form_state);
    $this->settingsForm->submitForm($form, $form_state);
  }

}
