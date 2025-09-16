<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Entoma</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="login-container">
    <!-- Lado izquierdo con imagen -->
    <div class="login-left">
      <img src="fondologin1.jpg" alt="Imagen Login" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAwIiBoZWlnaHQ9IjYwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48bGluZWFyR3JhZGllbnQgaWQ9ImdyYWQiIHgxPSIwJSIgeTE9IjAlIiB4Mj0iMTAwJSIgeTI9IjEwMCUiPjxzdG9wIG9mZnNldD0iMCUiIHN0b3AtY29sb3I9IiNlOTFlNjMiLz48c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiM5YzI3YjAiLz48L2xpbmVhckdyYWRpZW50PjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyYWQpIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIyNCIgZmlsbD0iI2ZmZiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkVudG9tYTwvdGV4dD48L3N2Zz4='">
    </div>

    <!-- Lado derecho con formulario -->
    <div class="login-right">
      <h2>Iniciar Sesión</h2>
      <form action="blogin.php" method="POST">
        <input type="email" name="correo" placeholder="Correo electrónico" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
      </form>

      <div class="extra">
        ¿No tienes cuenta? <a href="altausuario.php">Regístrate</a>
      </div>

      <div class="divider">o continúa con</div>

      <div class="social-login">
        <button class="google" type="button" onclick="alert('Función en desarrollo')">Google</button>
        <button class="facebook" type="button" onclick="alert('Función en desarrollo')">Facebook</button>
      </div>
    </div>
  </div>
</body>
</html>