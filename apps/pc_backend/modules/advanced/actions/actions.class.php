<?php

/**
 * advanced actions.
 *
 * @package    OpenPNE
 * @subpackage advanced
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class advancedActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }

  public function executeLayout(sfWebRequest $request)
  {
    $this->forward('design', 'layout');
  }

  public function executeBanner(sfWebRequest $request)
  {
    $this->forward('design', 'banner');
  }

  public function executeHtml(sfWebRequest $request)
  {
    $this->forward('design', 'html');
  }
}
