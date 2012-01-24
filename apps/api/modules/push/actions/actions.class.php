<?php

class pushActions extends opApiActions
{
  public function executeSearch(sfWebRequest $request)
  {
    $this->notifications = $this->getNotifications();

    $this->setTemplate('array');
  }

  public function executeCount(sfWebRequest $request)
  {
    $notifications = $this->getNotifications();

    $this->count = array(
      'link'    => 0,
      'message' => 0,
      'other'   => 0,
    );

    foreach ($this->notifications as $notification)
    {
      if (array_key_exists($notification['category'], $this->count))
      {
        $category = $notification['category'];
      }
      else
      {
        $category = 'other';
      }

      if ($notification['unread'])
      {
        $this->count[$category]++;
      }
    }

    $this->setTemplate('count');
  }

  protected function getNotifications(Member $member = null)
  {
    if (!$member)
    {
      $member = $this->getUser()->getMember();
    }

    $notifications = $member->getConfig('notification_center');

    if ($notifications)
    {
      $notifications = array();
    }
    else
    {
      $notifications = unserialize($notifications);
    }

    return $notifications;
  }
}
