<ul class="nav nav-tabs" style="  margin: 0 auto;">
<?php if ($icon == 'home') { ?>
            <li role="presentation" class="active"><a href="#">All</a></li>
            <li role="presentation"><a href="#">Family</a></li>
            <li role="presentation"><a href="#">Friends</a></li>
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    More <span class="caret"></span>
                </a>
                
                <ul class="dropdown-menu">
                    <li><a href="#">Placeholer</a></li>
                    <li><a href="#">Placeholer</a></li>
                    <li><a href="#">Placeholer</a></li>
                </ul>
            </li>
<?php } if ($icon == 'profile') { ?>
<li role="presentation"><a href="#">About</a></li>
            <li role="presentation" class="active"><a href="#">Posts</a></li>
            <li role="presentation"><a href="#">Photos</a></li>
            
<?php } ?>
        </ul>