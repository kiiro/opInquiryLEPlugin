この度は<?php echo opConfig::get('sns_name') ?>にお問い合わせありがとうございます。
以下の内容にてお問い合わせを受け付けました。
お問い合わせ内容、状況によっては数日のお時間を頂く場合がありますので、しばらくお待ちください。

※このメールはシステムにより自動送信しております。

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