<?php op_include_parts('formConfirm', 'inquiry_confirm', array(
  'title'  => __('Inquiry'),
  'body'   => sfConfig::get('app_inquiry_explanation_confirm'),
  'url'    => url_for('@inquiry_submit'),
  'button' => __('Send'),
  'align'  => 'center',
  'form'   => $form,
)) ?>
