<?php
function getPostsFromAPI() {
    $api_url = 'http://kspc.serv00.net/apiv1/fetch_posts_api.php';

    $json_data = file_get_contents($api_url);

    $posts = json_decode($json_data, true);
    
    return $posts;
}

function displayPosts($posts) {
  foreach ($posts as $post) {
      echo '<div class="message block">';
      echo '<a href="" class="avatar">';
      echo '<img alt="' . $post['username'] . '" src="https://www.startpage.com/av/proxy-image?piurl=https%3A%2F%2Ftse4.mm.bing.net%2Fth%3Fid%3DOIP.n3BKzWOcDwH5yOtN42eYKQHaHa%26pid%3DApi&sp=1710891600T9c217eae30c29ca2cc6eb51e516af5d632cc6350b8220be590f3a0d4136b173e' . $post['avatar_url'] . '" width="48" height="48" />';
      echo '</a>';
      echo '<div class="meta">';
      echo '<a href="#" class="user">' . $post['username'] . '</a>';
      echo '&nbsp;-&nbsp;';
      echo '<a href="#" class="when"><abbr class="timestamp" title="' . $post['timestamp'] . '">' . $post['formatted_timestamp'] . '</abbr></a>';
      echo '&nbsp;-&nbsp;';
      echo '<a href="#" class="to">' . $post['visibility'] . '</a>';
      echo '</div>';
      echo '<div class="text">';
      echo $post['content'];
      echo '</div>';
      echo '<div class="actions">';
      echo '<a href="#">Comment</a>';
      echo '&nbsp;-&nbsp;';
      echo '<a href="#">Share</a>';
      echo '</div>';
      echo '</div>'; 
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="Andras Barthazi - https://github.com/boogie" />
  <title>Loogle+</title>
  <link rel="stylesheet" href="stylesheets/gplus.css" />
  <link rel="stylesheet" href="stylesheets/jquery.tipsy.css" />
</head>
<body id="application">
  <div id="main" class="centered">

    <header>
      <ul id="menu">
        <li class="active"><a href="#">G+</a></li>
        <li><a href="#">Gmail</a></li>
        <li><a href="#">Calendar</a></li>
        <li><a href="#">Photos</a></li>
      </ul>
      <ul id="secondary">
        <li><a href="#">email@example.com</a></li>
        <li id="header-notifications"><a href="#" title="Notifications">0</a></li>
        <li><a href="#">Preferences</a></li>
      </ul>
    </header>

    <div id="top">
      <div class="container">
        <h1 id="site-logo">Google+</h1>
        <ul id="top-tabs">
          <li id="top-tab-home" class="active"><a href="#" title="Home" class="button left w-tip"><span>Home</span></a></li>
          <li id="top-tab-photos"><a href="#" title="Photos" class="button middle w-tip"><span>Photos</span></a></li>
          <li id="top-tab-profile"><a href="#" title="Profile" class="button middle w-tip"><span>Profile</span></a></li>
          <li id="top-tab-circles"><a href="#" title="Circles" class="button middle w-tip"><span>Circles</span></a></li>
          <li id="top-tab-games"><a href="#" title="Games" class="button right w-tip"><span>Games</span></a></li>
        </ul>
        <div id="top-search">
          <input id="top-search-input" class="focusable" placeholder="Find people" />
        </div>
      </div>
    </div>

    <div id="content">
      <div class="container">

        <nav>
          <ul>
            <li><a href="#">Welcome</a></li>
            <li class="active"><a href="#">Stream</a></li>
            <li><a href="#">Sparks</a></li>
          </ul>
        </nav>

        <section id="pane">
          <div class="block">
            <h2>Stream</h2>
            <textarea id="new-message" class="focusable b-autoheight" placeholder="Share what's new..."></textarea>
          </div>
          <div id="stream">
          <?php

          $posts = getPostsFromAPI();

          displayPosts($posts);
           ?>
          </div>
        </section>

     </div>
    </div>

  </div>
  <script src="javascripts/jquery.min.js"></script>
  <script src="javascripts/jquery.tipsy.js"></script>
  <script src="javascripts/jquery.autoheight.js"></script>
  <script src="javascripts/gplus.js"></script>
</body>
</html>