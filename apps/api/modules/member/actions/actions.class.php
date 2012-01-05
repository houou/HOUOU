<?php

class memberActions extends opApiActions
{
  public function executeCommunity(sfWebRequest $request)
  {
    if (isset($request['member_id']))
    {
      $memberId = $request['member_id'];
    }
    elseif (isset($request['id']))
    {
      $memberId = $request['id'];
    }
    else
    {
      $memberId = $this->getUser()->getMemberId();
    }

    $this->communities = Doctrine::getTable('Community')->createQuery('c')
      ->innerJoin('c.CommunityMember cm WITH cm.is_pre = false AND cm.member_id = ?', $memberId)
      ->limit(sfConfig::get('op_json_api_limit', 20))
      ->execute();

    $this->setTemplate('array', 'community');
  }
}
