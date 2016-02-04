<div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name"><img src="/assets/img/logo.png"></h1>
            </div>
            <h3>Bienvenidos a <?php echo $s->web->name ?></h3>
            <p></p>
            
            <form class="m-t" role="form" id="loginForm" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" id="user" name="user" value="<?php echo (isset($_COOKIE["_login"])) ? $_COOKIE["_login"] : '';?>" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                </div>
                <button type="submit" id="enter" name="enter" class="btn btn-primary block full-width m-b">Login</button>
				<input type="checkbox" id="remember" value="Value" class="styled" name="remember" /> Keep me logged in
                <p class="text-muted text-center"><a href="loginpass.php"><small>Forgot password?</small></a></p>
            </form>
            <p class="m-t"> <small><?php SiteSlogan ?></small> </p>
        </div>
    </div>