<?php

class WorkspaceController extends EntityAPIController {

  public function buildContent($entity, $view_mode = 'full', $langcode = NULL, $content = array()) {
    $wrapper = entity_metadata_wrapper('workspace', $entity);

    // Title as a pseudo-field
    $content['title'] = array(
      '#theme' => 'field',
      '#weight' => 0,
      '#title' => t('Title'),
      '#access' => TRUE,
      '#label_display' => 'above',
      '#view_mode' => $view_mode,
      '#language' => LANGUAGE_NONE,
      '#field_name' => 'title',
      '#field_type' => 'text',
      '#entity_type' => 'workspace',
      '#bundle' => 'workspace',
      '#items' => array(array('value' => $wrapper->title->value())),
      '#formatter' => 'text_default',
      0 => array('#markup' => check_plain($wrapper->title->value())),
    );

    // Description
    $content['description'] = array(
      '#theme' => 'field',
      '#weight' => 1,
      '#title' => t('Description'),
      '#access' => TRUE,
      '#label_display' => 'above',
      '#view_mode' => $view_mode,
      '#language' => LANGUAGE_NONE,
      '#field_name' => 'description',
      '#field_type' => 'text_long',
      '#entity_type' => 'workspace',
      '#bundle' => 'workspace',
      '#items' => array(array('value' => $wrapper->description->value())),
      '#formatter' => 'text_default',
      0 => array('#markup' => check_plain($wrapper->description->value())),
    );

    // Status with human readable label
    $status_label = '';
    $options = workspace_status_options();
    if (isset($options[$wrapper->status->value()])) {
      $status_label = $options[$wrapper->status->value()];
    }
    $content['status'] = array(
      '#theme' => 'field',
      '#weight' => 2,
      '#title' => t('Status'),
      '#access' => TRUE,
      '#label_display' => 'above',
      '#view_mode' => $view_mode,
      '#language' => LANGUAGE_NONE,
      '#field_name' => 'status',
      '#field_type' => 'list_integer',
      '#entity_type' => 'workspace',
      '#bundle' => 'workspace',
      '#items' => array(array('value' => $wrapper->status->value())),
      '#formatter' => 'list_default',
      0 => array('#markup' => check_plain($status_label)),
    );

    return parent::buildContent($entity, $view_mode, $langcode, $content);
  }
}
