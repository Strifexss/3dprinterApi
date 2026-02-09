<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Impressora API - Swagger UI</title>
  <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist/swagger-ui.css">
  <style>
    body { margin: 0; }
    #swagger-ui { height: 100vh; }
    .download-btn-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 32px;
      margin-bottom: 16px;
    }
    .download-btn {
      background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 12px 28px;
      font-size: 18px;
      font-weight: 600;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      cursor: pointer;
      transition: background 0.2s, transform 0.2s;
    }
    .download-btn:hover {
      background: linear-gradient(90deg, #0056b3 0%, #007bff 100%);
      transform: translateY(-2px) scale(1.03);
    }
  </style>
</head>
<body>
  <div class="download-btn-container">
    <button class="download-btn" onclick="window.location.href='/swagger.yaml'">
      ⬇️ Baixar Collection (swagger.yaml)
    </button>
  </div>
  <div id="swagger-ui"></div>
  <script src="https://unpkg.com/swagger-ui-dist/swagger-ui-bundle.js"></script>
  <script>
    window.onload = function() {
      SwaggerUIBundle({
        url: '/swagger.yaml',
        dom_id: '#swagger-ui',
        presets: [
          SwaggerUIBundle.presets.apis,
          SwaggerUIBundle.SwaggerUIStandalonePreset
        ],
        layout: "BaseLayout",
        validatorUrl: null,
        docExpansion: "none"
      });
    };
  </script>
</body>
</html>
