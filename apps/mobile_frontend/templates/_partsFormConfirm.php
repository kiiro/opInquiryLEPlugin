<?php
$options->setDefault('button', __('Send'));
$options->setDefault('return_button', __('戻る'));
$options->setDefault('url', url_for(sfContext::getInstance()->getRouting()->getCurrentInternalUri()));
$options->setDefault('method','post');
$options->setDefault('mark_required_field', true);
?>

<?php if (isset($options['body'])): ?>
<?php echo sfOutputEscaper::unescape($options['body']) ?>
<?php endif ?>

<form action="<?php echo $options['url'] ?>" method="<?php echo $options['method'] ?>">
<?php $forms = ($options['form'] instanceof sfForm) ? array($options['form']): $options['form'] ?>

<?php include_customizes($id, 'formTop') ?>

<?php $hasRequiredField = false ?>

<?php slot('form') ?>
<?php foreach ($forms as $form): ?>
<?php echo $form->renderHiddenFields() ?>
<?php
foreach ($form as $name => $field)
{

  if ($field->isHidden()) continue;
  $attributes = array();
  $widget = $field->getWidget();
  $validator = $form->getValidator($name);
  $value = '';

if ($widget instanceof sfWidgetFormInput)
{
  if (is_array($field->getValue()))
  {
    $value = $field->getValue();
    $value = $widget->escapeOnce($value['value']);
  }
  else
  {
    $value = $widget->escapeOnce($field->getValue());
  }
}
elseif ($widget instanceof sfWidgetFormChoice)
{
  $choices = $widget->getOption('choices');
  
  $value = $field->getValue();
  if (is_array($value))
  {
    $tmp = '';
    foreach($value as $v)
    {
      $tmp .= $widget->escapeOnce($choices[$v])."\n";
    }
    $value = $tmp;
  }
  else
  {
    $value = $widget->escapeOnce($choices[$value]);
  }
  $value = nl2br($value);
}
else
{
  if (is_array($field->getValue()))
  {
    $value = $field->getValue();
    $value = nl2br($widget->escapeOnce($value['value']));
  }
  else
  {
    $value = nl2br($widget->escapeOnce($field->getValue()));
  }
}

  if ($options['mark_required_field'] 
    && !($validator instanceof sfValidatorPass)
    && !($validator instanceof sfValidatorSchema)
    && $validator->getOption('required'))
  {
    echo sprintf('<font color="%s">*</font>', opColorConfig::get('core_color_22'));
    $hasRequiredField = true;
  }

  echo sprintf('<font color="%s">%s:</font><br>', opColorConfig::get('core_color_19'), $field->renderLabel());
  echo sprintf('%s<br>', $value);
  echo '<br>';
}
?>
<?php endforeach; ?>
<?php end_slot(); ?>

<?php if ($hasRequiredField): ?>
<?php echo __('%0% is required field.', array('%0%' => sprintf('<font color="%s">*</font>', opColorConfig::get('core_color_22')))) ?>
<hr color="<?php echo opColorConfig::get('core_color_11') ?>">
<?php endif; ?>

<?php slot('form_global_error') ?>
<?php foreach ($forms as $form): ?>
<?php if ($form->hasGlobalErrors()): ?>
<?php echo $form->renderGlobalErrors() ?>
<?php endif; ?>
<?php endforeach; ?>
<?php end_slot(); ?>
<?php if (get_slot('form_global_error')): ?>
<?php echo get_slot('form_global_error') ?><br><br>
<?php endif; ?>

<?php include_slot('form') ?>

<?php if (!empty($options['align'])): ?>
<div align="<?php echo $options['align'] ?>">
<?php else: ?>
<div>
<?php endif; ?>
<input type="submit" value="<?php echo $options['button'] ?>">
<input type="submit" name="return" class="input_submit" value="<?php echo $options['return_button'] ?>" />
</div>
<?php include_customizes($id, 'formBottom') ?>
</form>

