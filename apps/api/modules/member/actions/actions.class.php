<?php

class memberActions extends opApiActions
{
  public function executeCommunities(sfWebRequest $request)
  {
    $memberId = isset($request['member_id']) ? $request['member_id'] : $this->getUser()->getMemberId();

    $this->communities = Doctrine::getTable('Community')->createQuery('c')
      ->innerJoin('c.CommunityMember cm WITH cm.is_pre = false AND cm.member_id = ?', $memberId)
      ->execute();

    $this->setTemplate('array', 'community');
  }

  public function executeSearch(sfWebRequest $request)
  {
    $query = Doctrine::getTable('Member')->createQuery('m')
      ->andWhere('m.is_active = true');

    if (isset($request['target']))
    {
      if (!isset($request['target_id']))
      {
        $this->forward400('target_id parameter not specified.');
      }
      $targetId = $request['target_id'];

      if ('friend' === $request['target'])
      {
        $query->andWhere('EXISTS (FROM MemberRelationship mr WHERE m.id = mr.member_id_to AND mr.member_id_from = ?)', $targetId);
      }
      if ('community' === $request['target'])
      {
        $query->andWhere('EXISTS (FROM CommunityMember cm WHERE m.id = cm.member_id AND cm.community_id = ?)', $targetId);
      }
    }

    $this->members = $query
      ->limit(sfConfig::get('op_json_api_limit', 20))
      ->execute();

    $this->setTemplate('array');
  }

  public function executeFriendAccept(sfWebRequest $request)
  {
    if (isset($request['member_id']))
    {
      $targetMemberId = $request['member_id'];
    }
    elseif (isset($request['id']))
    {
      $targetMemberId = $request['id'];
    }
    else
    {
      $this->forward400('member_id parameter not specified.');
    }

    $memberId = $this->getUser()->getMemberId();

    $preRequest = Doctrine::getTable('MemberRelationship')->createQuery()
      ->addWhere('member_id_from = ?', $memberId)
      ->addWhere('member_id_to = ?', $targetMemberId)
      ->addWhere('is_friend_pre = true')
      ->fetchOne();

    if (!$preRequest)
    {
      $this->forward404('Invalid member_id.');
    }

    if (!$request['reject'])
    {
      $preRequest->setFriend();
    }
    else
    {
      $preRequest->removeFriendPre();
    }

    $preRequest->free(true);

    return $this->renderJSON(array('status' => 'success'));
  }
}
