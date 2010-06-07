<?php op_include_form('inquiry', $form, array(
  'title'  => __('Inquiry'),
  'body'   => sfConfig::get('app_inquiry_explanation_input'),
  'url'    => url_for('@inquiry_input'),
  'button' => __('Confirm'),
  'align'  => 'center',
)) ?>
