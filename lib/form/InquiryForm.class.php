<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * Inquiry form.
 *
 * @package    OpenPNE
 * @subpackage InquiryLE
 * @author     Naoto Inoue <inoue@adjust.ne.jp>
 */
class InquiryForm extends BaseForm
{
  public function setup()
  {
    foreach (sfConfig::get('app_inquiry_form_widgets') as $key => $value)
    {
      $obj = opFormItemGenerator::generateWidget($value);
      $this->setWidget($key, $obj);
      $this->setValidator($key, opFormItemGenerator::generateValidator($value));
      $this->widgetSchema->setLabel($key, $value['Caption']);
      $this->widgetSchema->setHelp($key, $value['Help']);
    }

    $this->widgetSchema->setNameFormat('inquiry[%s]');
  }

  public function sendMail()
  {
    $params = $this->getValues();
    
    if (!empty($params))
    {
      $from = opConfig::get('admin_mail_address');
      $member = sfContext::getInstance()->getUser()->getMember();
      $params['member_name'] = $member ? $member->getName() : null;
      $params['member_id'] = $member ? $member->getId() : null;
      $params['subject'] = '【'.opConfig::get('sns_name').'】'.sfConfig::get('app_inquiry_mail_subject');
      foreach(sfConfig::get('app_inquiry_form_widgets') as $key => $value)
      {
        if (in_array($value['FormType'], array('radio', 'select', 'checkbox')))
        {
          $tmp = array();
          if (!is_array($params[$key]))
          {
            $params[$key] = array($params[$key]);
          }
          foreach($params[$key] as $v)
          {
            $tmp[] = '・'.$value['Choices'][$v];
          }
          $params['details'][$value['Caption']] = implode("\n", $tmp);
        }
        else
        {
          $params['details'][$value['Caption']] = $params[$key];
        }
      }
      
      sfOpenPNEMailSend::sendTemplateMail('inquiryMail', $from, $from, $params);
      if (sfConfig::get('app_inquiry_mail_confirm_send'))
      {
        $params['subject'] = '【'.opConfig::get('sns_name').'】'.sfConfig::get('app_inquiry_mail_subject_confirm');
        sfOpenPNEMailSend::sendTemplateMail('inquiryMailConfirm', $params['mail_address'], $from, $params);
      }
    }
  }

}
