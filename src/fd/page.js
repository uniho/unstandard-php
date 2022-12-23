
//
export default props => {

  const mokuji = props.headings.map(item => {
    return html`
    <div key=${item.slug} onClick=${e => {
      try {
        const t = document.getElementById(item.slug)
        // const p = t.getBoundingClientRect().top + window.pageYOffset
        // window.scrollTo(0, p)
        if (t) t.scrollIntoView() 
      } catch(e) {
      }
    }}>
      ${item.text}
    </div>
    `
  })

  return html`
    <div className=${cx(props.css, cssPage)}>
      <div className="panel flex">
        <main className="flex-col">
          <div className="wrapper">
            ${props.children}
          </div>
        </main>
        <div className="mokuji-side-panel flex-col">
          <div className="mokuji flex-col">
            ${mokuji}
          </div>
        </div>
      </div>
    </div>
  `
}

//
const cssPage = css`

  display: flex;
  flex-direction: row;
  justify-content: center; 
  /* height: 100vh; */

  .panel {
    flex: 1;
    max-width: 1280px;
  }      

  main {
    flex: 1;
    min-height: 100%;
    padding: 1rem;
    /* overflow: auto; */
    .wrapper {
      /* padding: 1rem; */
    }
  }

  .mokuji-side-panel {
    position: relative;
    width: min(40%, 300px);
    .mokuji {
      position: fixed;
    }
  }

  @media screen and (max-width : ${window.frontmatter.breakpoints.md}px) {
    main {
      padding: 0.5rem;
    }
    .mokuji-side-panel {
      width: min(30%, 300px);
    }  
  }
  
  @media screen and (max-width : ${window.frontmatter.breakpoints.sm}px) {
    .mokuji-side-panel {
      display: none;
    }  
  }
`
