<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - TaskTim</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: url('/uploads/back.jpg') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      padding-left: 10%;
    }

    form {
      background: rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
      width: 340px;
      color: #1F2937;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-weight: 600;
      font-size: 1.5rem;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.8);
      font-size: 1em;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #6366F1;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      font-size: 1em;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #4F46E5;
    }

    .google-wrapper {
      text-align: center;
      margin-top: 15px;
    }

    .google-btn {
      display: inline-block;
      padding: 10px 16px;
      background: #DB4437;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-size: 0.95em;
      transition: background 0.3s ease;
    }

    .google-btn:hover {
      background: #C23321;
    }

    .links {
      text-align: center;
      margin-top: 15px;
      font-size: 0.9em;
    }

    .links a {
      display: block;
      margin: 4px 0;
      color: #1D4ED8;
      text-decoration: none;
    }

    .links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <form method="post" action="/login">
    <h2>Login duluu mass yaaa</h2>

    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Sandi" required>

    <button type="submit">Masuk</button>

    <div class="links">
  
      <a href="/register">Belum punya akun? Daftar</a>
    </div>


  </form>

</body>
</html>
