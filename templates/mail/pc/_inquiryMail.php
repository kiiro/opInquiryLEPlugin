以下の内容でお問い合わせを頂きました。

---------------------------------------------------
<?php if ($member_id = $sf_data->getRaw('member_id')): ?>
SNS上の名前：<?php echo $sf_data->getRaw('member_name') ?>

メンバーID：<?php echo $sf_data->getRaw('member_id') ?>

---------------------------------------------------
<?php endif; ?>
<?php
foreach($sf_data->getRaw('details') as $key => $value)
{
echo $key.'：'.$value."\n";
}
?>