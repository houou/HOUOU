<?php

$data = array();

foreach ($notifications as $notification)
{
  $data[] = array(
    'body' => $notification['body']
    'category' => $notification['category'],
    'unread' => $notification['unread'],
    'created_at' => date('r', strtotime($notification['created_at'])),
    'icon_url' => sf_image_path($notification['icon_url'], array('size' => '48x48'), true),
    'url' => $notification['url'] ? url_for($notification['url'], array('abstract' => true)) : null,
    'member_id_from' => $notification['member_id_from'],
  );
}

return array(
  'status' => 'success',
  'data' => $data
)
