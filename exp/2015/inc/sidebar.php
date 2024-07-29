
<ul id="slide-out" class="sidenav sidenav-fixed">
    <li><a href="index.php"><i class="material-icons">home</i><span>Home</span></a></li>
    <li><a href="youmaylike.php"><i class="material-symbols-outlined" style="font-size: 34px;">communities</i><span>Communities</span></a></li>
</span>
    <?php if (isset($_SESSION['username'])) { ?>
        <li><a href="profile.php?username=<?php echo $_SESSION['username']; ?>"><i class="material-icons">person</i><span>Profile</span></a></li>
    <?php } ?>
    <li><a href="people.php"><i class="material-icons">group</i><span>People</span></a></li>  
    <li class="divider"></li>
    <?php if (!isset($_SESSION['username'])) { ?>
        <li><a href="login.php"><i class="material-icons">login</i><span>Login</span></a></li>
        <li><a href="register_user.php"><i class="material-icons">person_add</i><span>Register</span></a></li>
    <?php } ?>
</ul>
