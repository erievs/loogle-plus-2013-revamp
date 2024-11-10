<div class="test">
<header class="nav-wrapper">
    <span class="left-shit">
    <a id="menu-icon" class="sidenav-trigger" style="cursor: pointer ;"><i class="material-icons" style="vertical-align: middle; margin-bottom: 2px; color: white;">menu</i></a>
        &nbsp;&nbsp; Home

    </span>
    <div class="menu-icon">
    <i class="material-icons" id="open-popup-menu">more_vert</i>

    <div class="popup-menu" id="popup-menu">
    <div id="refresh-posts" class="popup-item">
        <button id="pleasegodwork">Refresh Posts<button>
    </div>

</div>

</div>

</header>
</div>

<br>
<br>
<br>

<div class="container" id="main-content">
    <div class="row">
        <div class="col s12">
            
            <?php
            displayPosts($posts); 
            ?>
        </div>
    </div>
</div>