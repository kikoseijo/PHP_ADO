<div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">AZ+</h1>
            </div>
            <h3><?php echo $title?></h3>
            <p></p>
			
            
            <form class="m-t" role="form" action="login_password.php" id="login_form" method="post">
                <?php 
				if (isset($hecho) && $hecho){ 
					echo "<fieldset><legend>Felecidades</legend>Te hemos enviado la constrase&ntilde;a a tu email.</fieldset>";}
           		else {
            	?>
            	<p>Por favor intruduzca su usuario o contraseña para recibir por email una contraseña nueva.</p>
            	<div class="form-group">
                    <input type="text" class="form-control" placeholder="Usuario" id="user" name="user" size="32" value="<?php echo isset($_COOKIE["_login"]) ?  $_COOKIE["_login"] : '';?>"/>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" id="email" name="email" size="32" />
                    <input type="hidden" id="enter" name="enter" size="32" value="1" />
                </div>
                <button type="submit" id="enter" name="enter" class="btn btn-primary block full-width m-b">Enviar formulario</button>
				<?php } ?>
                <p class="text-muted text-center"><a href="/login.php"><small>Volver</small></a></p>
            </form>
            <p class="m-t"> <small><?php echo $s->web->name ?> <?php echo $s->web->domain ;?> &copy; <?php echo date('Y')?></small> </p>
        </div>
    </div>