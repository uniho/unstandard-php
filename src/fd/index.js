
import {cx, css, keyframes, injectGlobal} from 'https://cdn.skypack.dev/@emotion/css@11?min'
import * as stylis from 'https://cdn.skypack.dev/stylis@4?min'
import ErrorBoundary from 'modules/error-boundary.js'

window.html = htm.bind(React.createElement)
window.raw = window.styled = String.raw
window.cx = cx
window.css = css
window.keyframes = keyframes
window.injectGlobal = injectGlobal
window.stylis = stylis

window.Fragment = React.Fragment
window.Suspense = React.Suspense

export const main = async props => {

  window.frontmatter = props.frontmatter

  const modules = await Promise.all([
    import('/page.js'),
    import('/css.js'),
  ])

  const Markdown = React.createElement('div', {
    className: cx(modules[1].cssMarkdown, css(props.style)),
  }, React.createElement('div', {
    dangerouslySetInnerHTML: {__html: props.content}
  }))

  //
  const App = () => {
    React.useLayoutEffect(() => {
      window.Prism.highlightAll();
    }, [])

    return React.createElement(ErrorBoundary, {},
      React.createElement(modules[0].default, {
        css: modules[1].cssBase,
        headings: props.headings,
        // frontmatter: props.frontmatter,
      }, Markdown)
    )
  }

  const root = ReactDOM.createRoot(document.getElementById("app"))
  root.render(React.createElement(App))
}
