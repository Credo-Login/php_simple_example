<?php
session_start();

$client_id = 'CLIENT_ID';
$client_secret = 'CLIENT_SECRET';
$redirect_uri = 'http://localhost:8080/';
$authorize_url = 'https://usecredo.com/api/oauth2/authorize';
$token_url = 'https://usecredo.com/api/oauth2/token';
$user_url = 'https://usecredo.com/user';

function http($url, $params=false, $token=null) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  if($params)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
  if($token)
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$token]);
  return json_decode(curl_exec($ch));
}

if(isset($_SESSION['username'])) {
  echo '<p>Hello, <b>'.$_SESSION['username'].'</b></p>';
  echo '<p><a href="/?logout">Log Out</a></p>';
} else {
  $authorize_url = $authorize_url.'?'.http_build_query([
    'response_type' => 'code',
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
  ]);
  echo '<p><a href="'.$authorize_url.'">Log In With Credo</a></p>';
}

if(isset($_GET['code'])) {
  $response = http($token_url, [
    'grant_type' => 'authorization_code',
    'code' => $_GET['code'],
    'redirect_uri' => $redirect_uri,
    'client_id' => $client_id,
    'client_secret' => $client_secret,
  ]);

  $user = http($user_url, [], $response->access_token->value);

  if($user->username) {
    $_SESSION['username'] = $user->username;
    header('Location: /');
  }
}

if(isset($_GET['logout'])) {
  unset($_SESSION['username']);
  header('Location: /');
}
