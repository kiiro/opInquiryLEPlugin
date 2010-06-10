<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opInquiryPluginInquiry actions.
 *
 * @package    OpenPNE
 * @subpackage InquiryLE
 * @author     Naoto Inoue <inoue@adjust.ne.jp>
 */
class opInquiryLEPluginInquiryActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward($this->getModuleName(), 'input');
  }

 /**
  * Executes input action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeInput(sfWebRequest $request)
  {
    $this->form = new InquiryForm();

    if (!$request->isMethod('post'))
    {
      if ($params = $this->getUser()->getFlash($this->form->getName()))
      {
        $this->form->bind($params);
      }
    }
    else
    {
      $params =  $this->getRequestParameter($this->form->getName());
      
      $this->form->bind($params);
      if ($this->form->isValid())
      {
        $this->getUser()->setFlash($this->form->getName(), $params);
        $this->setTemplate('confirm');
        
        return sfView::SUCCESS;
      }
    }
    
    return sfView::SUCCESS;
  }

 /**
  * Executes submit action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeSubmit(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new InquiryForm();

    $this->forward404Unless($params = $this->getUser()->getFlash($this->form->getName()));

    if ($this->getRequestParameter('return') != '')
    {
      $this->getUser()->setFlash($this->form->getName(), $params);
      $this->redirect($this->getModuleName().'/input');
    }
    
    $this->form->bind($params);
    if($this->form->isValid())
    {
      $this->form->sendMail();
      $this->redirect($this->getModuleName().'/complete');
    }
    else
    {
      $this->forward404();
    }
  }

 /**
  * Executes complete action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeComplete(sfWebRequest $request)
  {
    return sfView::SUCCESS;
  }
}
