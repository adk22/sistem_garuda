<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sticky Footer Garuda Indonesia Denpasar</title>

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />

    <style>
      :root {
        --footer-bg-color: #003b7a;
      }

      * {
        box-sizing: border-box;
      }

      html,
      body {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: Arial, sans-serif;
      }

      .page-container {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
      }

      .content {
        flex: 1;
        padding: 20px;
        background-color: #f5f5f5;
      }

      .footer {
        background-color: var(--footer-bg-color);
        color: white;
        text-align: center;
        padding: 20px 10px;
      }

      .footer-slogan {
        font-size: 15px;
        font-style: italic;
        margin-bottom: 10px;
      }

      .footer-icons {
        margin-bottom: 10px;
      }

      .footer-icons a {
        background-color: white;
        border-radius: 50%;
        display: inline-block;
        width: 32px;
        height: 32px;
        margin: 0 6px;
        line-height: 32px;
        text-align: center;
        font-size: 16px;
        color: var(--footer-bg-color);
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
      }

      .footer-icons a:hover {
        background-color: #0055aa;
        color: white;
      }

      .footer-text {
        font-size: 14px;
        margin: 5px 0 0;
      }

      /* Responsive untuk layar kecil */
      @media (max-width: 480px) {
        .footer-icons a {
          width: 28px;
          height: 28px;
          line-height: 28px;
          font-size: 14px;
          margin: 0 4px;
        }

        .footer {
          padding: 16px 10px;
        }

        .footer-slogan {
          font-size: 14px;
        }

        .footer-text {
          font-size: 13px;
        }
      }
    </style>
  </head>
  <body>

      <!-- Footer -->
      <footer class="footer">
        <p class="footer-slogan">Because you matter</p>
        <div class="footer-icons">
          <a href="#" aria-label="Facebook"
            ><i class="fab fa-facebook-f"></i
          ></a>
          <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
          <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
        <p class="footer-text">© 2025 Garuda Indonesia Denpasar</p>
      </footer>
    </div>
  </body>
</html>
