<?php slot('body'); ?>
送信を完了しました｡<br>
<br>
お問い合わせ内容､状況によっては数日のお時間を頂く場合がありますので、しばらくお待ちください。
<?php end_slot(); ?>
<?php op_include_box('box', get_slot('body'), array(
  'title'  => __('Inquiry'),
)) ?>

