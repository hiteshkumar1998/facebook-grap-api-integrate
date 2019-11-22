<?php

//run below command for package intallation

//composer require facebook/graph-sdk

//session starts here
session_start();

//includes autoload file
require_once __DIR__ . '/vendor/autoload.php';

//set client credentials
$fb = new \Facebook\Facebook([
  'app_id' => '{ app id here }',
  'app_secret' => '{ secret id here }',
  'default_graph_version' => 'v2.10',
]);

  $helper = $fb->getRedirectLoginHelper();
  $login_url = $helper->getLoginUrl('http://localhost/loginfb/fb-login.php');
  
try 
{
  $accessToken = $helper->getAccessToken();
  if(isset($accessToken))
  {
      $_SESSION['access_token'] = (string)$accessToken;
      header('Location:index.php');
  }
}
catch(Exception $e)
{
  echo $e->getTraceAsString();
}

if(isset($_SESSION['access_token']))
{
  try
  {
    $fb->setDefaultAccessToken($_SESSION['access_token']);
    $res = $fb->get('/me?fields=name,id,picture.type(large)');
    $user = $res->getGraphUser();
    $image = $user->getField('picture');
    echo 'User Id - '.$user->getField('id').'<br/>';
    echo 'Username - '.$user->getField('name').'<br/>';
    echo '<img src="'.$image['url'].'" /><br>';
    
  }
  catch (Exception $e)
  {
    echo $e->getTraceAsString();
  }
} 

