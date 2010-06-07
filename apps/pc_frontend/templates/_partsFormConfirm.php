<?php
$options->setDefault('button', __('Send'));
$options->setDefault('return_button', __('戻る'));
$options->setDefault('url', url_for(sfContext::getInstance()->getRouting()->getCurrentInternalUri()));
$options->setDefault('method','post');
$options->setDefault('firstRow', '');
$options->setDefault('lastRow', '');
$options->setDefault('mark_required_field', true);
?>

<form action="<?php echo $options->getRaw('url') ?>" method="<?php echo $options['method'] ?>"<?php if (!empty($options['isMultipart'])): ?> enctype="multipart/form-data"<?php endif; ?>>
<?php $forms = ($options['form'] instanceof sfform) ? array($options['form']) : $options['form'] ?>

<?php include_customizes($id, 'formTop') ?>

<?php if (isset($options['body'])): ?>
<div class="block">
<?php echo $options['body'] ?>
</div>
<?php endif ?>

<?php $hasRequiredField = false ?>

<?php slot('form_table') ?>
<table>
<?php include_customizes($id, 'firstRow') ?>
<?php echo $options->getRaw('firstRow') ?>

<?php foreach ($forms as $form): ?>
<?php foreach ($form as $name => $field): ?>
<?php if ($field->isHidden()) continue; ?>
<?php
$attributes = array();
$value = '';
$widget     = $field->getWidget();
$validator  = $form->getValidator($name);
$labelSuffix = '';
$publicFlg = '';

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
  $labelSuffix = ' <strong>*</strong>';
  $hasRequiredField = true;
}
?>
<tr>
  <th><?php echo $field->renderLabel() ?><?php echo $labelSuffix?></th>
  <td><?php echo $value ?></td>
</tr>
<?php endforeach; ?>
<?php endforeach; ?>
<?php echo $options->getRaw('lastRow') ?>
<?php include_customizes($id, 'lastRow') ?>
</table>
<?php end_slot(); ?>

<?php if ($hasRequiredField): ?>
<?php echo __('%0% is required field.', array('%0%' => '<strong>*</strong>')) ?>
<?php endif; ?>

<?php include_slot('form_table') ?>

<div class="operation">
<ul class="moreInfo button">
<li>
<input type="submit" name="return" class="input_submit" value="<?php echo $options['return_button'] ?>" />
<input type="submit" class="input_submit" value="<?php echo $options['button'] ?>" />
</li>
</ul>
</div>
<?php include_customizes($id, 'formBottom') ?>
</form>
