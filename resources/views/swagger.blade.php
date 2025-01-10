<!--
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2025, Tomáš Chochola <chocholatom1997@gmail.com>. Some rights reserved.
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomchochola} GitHub Personal
 * @see {@link https://github.com/premierstacks} GitHub Organization
 * @see {@link https://github.com/sponsors/tomchochola} GitHub Sponsors
-->

<!doctype html>
<html lang="{{ $locale ?? \Premierstacks\LaravelStack\Config\Conf::inject()->getAppLocale() }}">
<head>
  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="description" content="{{ $description ?? 'Swagger UI' }}" />
  <meta name="keywords" content="{{ $keywords ?? 'premierstacks, laravel-stack, tomchochola, psls, swagger-ui' }}" />
  <meta name="author" content="{{ $author ?? 'Tomáš Chochola <chocholatom1997@gmail.com>' }}" />

  @isset($norobots)
  <meta name="robots" content="noindex, nofollow" />
  @endisset

  <title>{{ $title ?? 'Swagger UI' }}</title>

  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />

  <link rel="icon" type="image/png" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist/favicon-32x32.png" sizes="32x32" crossorigin="anonymous" />
  <link rel="icon" type="image/png" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist/favicon-16x16.png" sizes="16x16" crossorigin="anonymous" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist/index.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist/swagger-ui.min.css" crossorigin="anonymous" />

  <script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist/swagger-ui-bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist/swagger-ui-standalone-preset.min.js" crossorigin="anonymous"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      window.ui = new SwaggerUIBundle({
        url: {!! isset($url) ? "'{$url}'" : 'void 0' !!},
        spec: {!! isset($spec) ? "'{$spec}'" : 'void 0' !!},
        dom_id: 'body',
        deepLinking: true,
        presets: [SwaggerUIBundle.presets.apis, SwaggerUIStandalonePreset],
        plugins: [SwaggerUIBundle.plugins.DownloadUrl],
        layout: 'StandaloneLayout',
      });
    });
  </script>
</head>
<body></body>
</html>
