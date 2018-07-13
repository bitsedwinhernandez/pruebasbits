<?php

namespace Drupal\bits_forms\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\HttpFoundation;

/**
 * Class SimpleForm.
 */
class SimpleForm extends FormBase {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a new SimpleForm object.
   */
  public function __construct(
    Connection $database,
    AccountProxyInterface $current_user
  ) {
    $this->database = $database;
    $this->currentUser = $current_user;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('current_user')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'simple_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['titulo'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Título'),
      '#maxlength' => 30,
      '#minlength' => 30,
      '#size' => 30,
      '#weight' => '0'
    ];
    $form['nombre_de_usuario'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Nombre de usuario'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
      '#default_value'=>$this->currentUser->getAccountName()
    ];
    $form['correo_electronico'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Correo electrónico'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
      '#default_value'=>$this->currentUser->getEmail()
    ];
    $form['submit'] = [
      '#type' => 'button',
      '#title' => $this->t('Submit'),
      '#weight' => '0',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $values = $form_state->getValues();
    if (!valid_email_address($values['correo_electronico'])) {
      $form_state->setErrorByName('correo_electronico', $this->t('The email address appears to be invalid.'));
    }
    if(ctype_upper($values['titulo'])){
      $form_state->setErrorByName('titulo', $this->t('The title appears to be invalid.') . ctype_upper($values['titulo']));
    }
    if($this->currentUser->id()!=0){

    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    try{
      $this->database->insert('bits_forms_simple')->fields([
        'title'=>$values['titulo'],
        'uid'=> ($this->currentUser->id() == 0) ? 0 : $this->currentUser->id(),
        'username'=>$values['nombre_de_usuario'],
        'email'=>$values['correo_electronico'],
        'ip'=>\Drupal::request()->getClientIp(),
        'timestamp'=>time()
      ]);
      drupal_set_message('Se guardo el usuario: ' . $values['nombre_de_usuario']);
      \Drupal::logger('bits_forms_simple')->notice('Insertado %title por el usuario %user con id %id',
        array(
            '%user' => $this->currentUser->id(),
            '%title' => $values['titulo'],
            '%user' => $values['nombre_de_usuario']
        ));
      $form_state->setRedirect('bits_pages.simple');
    }catch(Exception $e){
      drupal_set_message('Excepción capturada: ' . $e->getMessage());
    }
  }

}
