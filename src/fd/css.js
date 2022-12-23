
const cssMarkdownBase = css`

/* Toolbar for copying */

  div.code-toolbar 
  {
    position: relative;
  }

  div.code-toolbar > .toolbar 
  {
    position: absolute;
    top: 0.3em;
    right: 0.2em;
    transition: opacity 0.3s ease-in-out;
    opacity: 0;
  }

  div.code-toolbar:hover > .toolbar 
  {
    opacity: 1;
  }

  div.code-toolbar > .toolbar .toolbar-item 
  {
    display: inline-block;
    padding-right: .5rem;
  }

  div.code-toolbar > .toolbar a 
  {
    cursor: pointer;
  }

  div.code-toolbar > .toolbar button 
  {
    background: none;
    border: 0;
    color: inherit;
    font: inherit;
    line-height: normal;
    overflow: visible;
    padding: 0;
    -webkit-user-select: none; /* for button */
    -moz-user-select: none;
    -ms-user-select: none;
  }

  div.code-toolbar > .toolbar a,
  div.code-toolbar > .toolbar button,
  div.code-toolbar > .toolbar span 
  {
    color: ${window.frontmatter.css.palette.primary['contrast-text']};
    font-family: Roboto;
    font-size: 12px;
    padding: .2rem;
    background: ${window.frontmatter.css.palette.primary.light};
    border-radius: 2px;
    cursor: pointer;
    transition: background-color .2s;
  }

  div.code-toolbar > .toolbar a:hover,
  div.code-toolbar > .toolbar a:focus,
  div.code-toolbar > .toolbar button:hover,
  div.code-toolbar > .toolbar button:focus,
  div.code-toolbar > .toolbar span:hover,
  div.code-toolbar > .toolbar span:focus 
  {
    /* color: inherit; */
    text-decoration: none;
    /* background: radial-gradient(closest-side, ${window.frontmatter.css.palette.primary.dark}, ${window.frontmatter.css.palette.primary.light}); */
    background: ${window.frontmatter.css.palette.primary.main};
    /* transform: scale(1.05, 1.05); */
  }

  .indent, .indent1 {
    padding-left: 1rem;
  }
  .indent2 {
    padding-left: 2rem;
  }
  .indent3 {
    padding-left: 3rem;
  }
  .indent4 {
    padding-left: 4rem;
  }
  .indent5 {
    padding-left: 5rem;
  }
  .text-indent, .text-indent1{
    text-indent: 1rem;
  }
  .text-indent2 {
    text-indent: 2rem;
  }
  .text-indent3 {
    text-indent: 3rem;
  }
  .text-indent4 {
    text-indent: 4rem;
  }
  .text-indent5 {
    text-indent: 5rem;
  }
`

const cssMarkdownHeadingsInner = css`
  font-weight: normal;
  & > a {
    display: block;
    color: inherit;
    text-decoration: none;
  }
`

const cssMarkdownHeadings = css([2, 3, 4, 5, 6].map(num => ({
  ['h' + num] : cssMarkdownHeadingsInner,
})))

export const cssMarkdown = css(
  cssMarkdownHeadings,
  cssMarkdownBase,
)


export const cssBase = css`
  .flex {
    display: flex;
  }
  .flex-col {
    display: flex;
    flex-direction: column;
  }
  .inline	{
    display: inline;
  }
  .block {
    display: block;	
  }
  .hidden {
    display: none;	
  }
  .hidden-important {
    display: none !important;	
  }

  .j-center {
    justify-content: center;
  }
  .i-center {
    align-items: center;  
  }

  .mt-1 {
    margin-top: .25rem;	
  }
  .mt-2 {
    margin-top: .5rem;	
  }
  .mt-3 {
    margin-top: .75rem;	
  }
  .mt-4 {
    margin-top: 1rem;	
  }
  .mt-5 {
    margin-top: 1.25rem;	
  }
  .mt-6 {
    margin-top: 1.5rem;	
  }
  .mt-7 {
    margin-top: 1.75rem;	
  }
  .mt-8 {
    margin-top: 2rem;	
  }

  .w-full {
    width: 100%;
  }
`
