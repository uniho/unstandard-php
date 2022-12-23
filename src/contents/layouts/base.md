---

---

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>React Page</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/preflight.css">
    <link rel="stylesheet" href="css/style.css">
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

  <slot/>

  <!-- <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script> -->
  <script crossorigin src="https://unpkg.com/react@18.3.0-next-e98225485-20221129/umd/react.development.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18.3.0-next-e98225485-20221129/umd/react-dom.development.js"></script>
  <script crossorigin src="https://unpkg.com/htm"></script>

  <script async src="https://unpkg.com/es-module-shims/dist/es-module-shims.js"></script>
  <script type="importmap">
    {
      "imports": {
        "modules/": "./modules/",
        "pages/": "./pages/",
        "icons/": "./icons/",
        "index": "./index.js"
      }
    }
  </script>
  <script type="module">
    import "index"
  </script>

</html>
