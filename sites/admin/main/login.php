<!-- login.php -->
<?php require_once '../../config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <h2>Login</h2>
  <form id="loginForm">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
    
  </form>
  <p id="message" style="color: red;"></p>

    

  <script>
    document.getElementById('loginForm').addEventListener('submit', async function (e) {
      e.preventDefault();
      const formData = new FormData(e.target);

      const res = await fetch('login-handler.php', {
        method: 'POST',
        body: formData
      });

      try {
        const result = await res.json();
        if (result.success) {
          window.location.href = 'admin.php';
        } else {
          document.getElementById('message').textContent = result.message;
        }
      } catch (err) {
        document.getElementById('message').textContent = 'Unexpected response from server.';
        console.error('JSON parse error:', err);
      }
    });
  </script>
</body>
</html>
