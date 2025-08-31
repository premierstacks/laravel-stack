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
<html lang="en">
<head>
  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0, interactive-widget=overlays-content, viewport-fit=cover, shrink-to-fit=no" />

  <meta name="description" content="{{ $description ?? 'OpenAPI' }}" />
  <meta name="keywords" content="{{ $keywords ?? 'OpenAPI' }}" />
  <meta name="author" content="{{ $author ?? 'Tomáš Chochola <chocholatom1997@gmail.com>' }}" />

  @isset($norobots)
  <meta name="robots" content="noindex, nofollow" />
  @endisset

  <title>{{ $title ?? 'OpenAPI' }}</title>

  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin="anonymous" />
</head>
<body>
  <script id="api-reference" data-url="{{ $url ?? '' }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/@scalar/api-reference" crossorigin="anonymous"></script>
</body>
</html>
