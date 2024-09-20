window.onload = function() {
  //<editor-fold desc="Changeable Configuration Block">

  // the following lines will be replaced by docker/configurator, when it runs in a docker-container
  window.ui = SwaggerUIBundle({
    url: "swagger/swagger.json",
    dom_id: '#swagger-ui',
    deepLinking: true,
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    plugins: [
      // SwaggerUIBundle.plugins.DownloadUrl
      SwaggerUIBundle.plugins.TopbarPlugin // Désactivez ce plugin
    ],
    // layout: "StandaloneLayout", 
    layout: "BaseLayout" // Utilisez un layout qui n'inclut pas la topbar
  });

  //</editor-fold>
};
