---

---

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>React Page</title>
    <link rel="stylesheet" href="fd/css/normalize.css">
    <link rel="stylesheet" href="fd/css/preflight.css">
    <link rel="stylesheet" href="fd/css/style.css">
    <link rel="stylesheet" href="fd/css/prism-vsc-dark-plus.css">
  </head>
  <body>
    <div id="app"></div>
  </body>

  <noscript>
    <div style="height:100vh; display:flex; align-items:center; justify-content:center;">You need to enable JavaScript to run this app.</div>
  </noscript>
  
  <script>
    {
      const UA = window.navigator.userAgent.toLowerCase()
      if (UA.match(/msie|trident/)) {
        const style = document.createElement('style')
        style.textContent = '#app {height: 100vh; padding: 0 2rem; display: flex; justify-content: center; align-items: center;}'
        const warn = document.createElement('div')
        warn.textContent = 'You are using Internet Explorer yet? Please upgrade your browser.'
        document.getElementById("app").appendChild(style)
        document.getElementById("app").appendChild(warn)
        throw new Error()
      }
    }
  </script>

  <!-- <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script> -->
  <script crossorigin src="https://unpkg.com/react@18.3.0-next-e98225485-20221129/umd/react.development.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18.3.0-next-e98225485-20221129/umd/react-dom.development.js"></script>
  <script crossorigin src="https://unpkg.com/htm@3"></script>

  <script src="https://unpkg.com/prismjs@1/components/prism-core.min.js"></script>
  <script src="https://unpkg.com/prismjs@1/plugins/autoloader/prism-autoloader.min.js"></script>
  <!-- <script src="https://unpkg.com/prismjs@1/plugins/line-numbers/prism-line-numbers.min.js"></script> -->
  <script src="https://unpkg.com/prismjs@1/plugins/toolbar/prism-toolbar.min.js"></script>
  <script src="https://unpkg.com/prismjs@1/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>

  <script async src="https://unpkg.com/es-module-shims@1/dist/es-module-shims.js"></script>
  <script type="importmap">
    {
      "imports": {
        "/": "./fd/",
        "modules/": "./fd/modules/",
        "pages/": "./fd/pages/",
        "icons/": "./fd/icons/"
      }
    }
  </script>

  <script type="module">
    import {main} from "/index.js";
    main({markdown:"<slot/>"});
  </script>

</html>
