
<div class="body-1-2"></div>
	<form action="" method="POST" autocomplete="off">
		<div class="header-login">
			<div>Account<span></br>Condominium</span></div>
		</div>
		<br> 
		<div class="login">
				<input  type="text" pattern="[a-zA-Z0-9]{4,20}" placeholder="Username" maxlength="20" name="login_usuario" ><br>
				<input  type="password" name="login_clave" placeholder="Password" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required><br>
				<button type="submit" class="button is-info is-rounded">Iniciar sesion</button>
			
				<?php
			if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
				require_once "./php/main.php";
				require_once "./php/iniciar_sesion.php";
			}
		?>
	</form>
</div>