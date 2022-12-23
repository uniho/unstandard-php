---
layout: react
test2: てすとに

css:
  palette:
    primary:
      main: "#3f51b5"
      light: rgb(101, 115, 195)
      dark: rgb(44, 56, 126)
      contrast-text: "#fff"
    secondary:
      main: "#f50057"
      light: rgb(247, 51, 120)
      dark: rgb(171, 0, 60)
      contrast-text: "#fff"
    error:
      main: "#d60a34"
      light: "#feebee"
      dark: "red"
      contrast-text: "#fff"
    warning:
      main: "#f7a535"
      light: "#fdf9e2"
      dark: "#f9a825"
      contrast-text: rgba(0, 0, 0, 0.87)
    info:
      main: "#55c500"
      light: "#e3f7df"
      dark: "green"
      contrast-text: "#fff"
    success:
      main: "#4caf50"
      light: "#81c784"
      dark: "#388e3c"
      contrast-text: rgba(0, 0, 0, 0.87)
    background:
      default: "#fafafa"
      paper: "#fff"
    text:
      primary: rgba(0, 0, 0, 0.87)
      secondary: rgba(0, 0, 0, 0.54)
      disabled: rgba(0, 0, 0, 0.38)
      hint: rgba(0, 0, 0, 0.38)
      heading: rgb(44, 56, 126)
    divider: rgba(0, 0, 0, 0.12)
    
---
<style>
  & {
    line-height: 1.5;
    font-size: 1rem;
    color: {{css.palette.text.primary}};
    background-color: {{css.palette.background.default}};
  }

  h1 {
    color: {{css.palette.primary.contrast-text}};
    background-color: {{css.palette.primary.main}};
    font-size: 1.5rem;
    line-height: 1.5rem;
    font-weight: normal;
    /* margin-top: 1.2rem; */
    margin-bottom: .5rem;
    padding-top: .5rem;
    padding-bottom: .5rem;
    padding-left: 1rem;
  }

  h2 {
    color: {{css.palette.primary.contrast-text}};
    background-color: {{css.palette.primary.light}};
    font-size: 1.3rem;
    line-height: 1.3rem;
    margin-top: 1.2rem;
    margin-bottom: .5rem;
    /* margin-right: 10%; */
    & > * {
      padding-top: .5rem;
      padding-bottom: .5rem;
      padding-left: 1rem;
      padding-right: .5rem;
      /* border-left: solid .8rem;
      border-bottom: solid 1px; */
    }
  }    

  h3 {
    color: {{css.palette.text.heading}};
    font-size: 1.3rem;
    line-height: 1.3rem;
    margin-top: 1.2rem;
    margin-bottom: .5rem;
    margin-right: 10%;
    padding-left: .1rem;
    & > * {
      padding-top: .2rem;
      padding-bottom: .2rem;
      padding-left: .5rem;
      padding-right: .5rem;
      border-left: solid .8rem;
      border-bottom: solid 1px;
    }
  }    

  h4 {
    color: {{css.palette.text.heading}};
    font-size: inherit;
    line-height: inherit;
    margin-top: 1.2rem;
    margin-bottom: .5rem;
    margin-right: 10%;
    padding-left: .1rem;
    & > * {
      padding-top: .2rem;
      padding-bottom: .2rem;
      padding-left: .5rem;
      padding-right: .5rem;
      border-left: solid .3rem;
      border-bottom: solid 1px;
    }
  } 

  h5 {
    color: {{css.palette.text.heading}};
    font-size: inherit;
    line-height: inherit;
    margin-top: 1.2rem;
    margin-bottom: .5rem;
    margin-right: 10%;
    padding-left: .1rem;
    & > * {
      padding-top: .2rem;
      padding-bottom: .2rem;
      padding-left: .5rem;
      padding-right: .5rem;
      border-left: dotted 1px;
      border-bottom: dotted 1px;
    }
  }    

  h6 {
    color: {{css.palette.text.heading}};
    font-size: inherit;
    line-height: inherit;
    margin-top: 1.2rem;
    margin-bottom: .5rem;
    /* margin-right: 10%; */
    padding-left: .1rem;
    padding-top: .2rem;
    padding-bottom: .2rem;
    padding-left: .5rem;
    padding-right: .5rem;
    border-left: dotted 1px;
    /* border-bottom: dotted 1px; */
  }    

  em {
    font-style: normal;
    font-weight: normal;
    /* color: {{css.palette.info.contrast-text}}; */
    background: linear-gradient(transparent 70%, {{css.palette.info.main}} 0%);
  }

  strong {
    font-style: normal;
    font-weight: normal;
    /* color: {{css.palette.warning.contrast-text}}; */
    background: linear-gradient(transparent 70%, {{css.palette.warning.main}} 0%);
    
    em {
      /* color: {{css.palette.error.contrast-text}}; */
      background: linear-gradient(transparent 70%, {{css.palette.error.main}} 0%);
    }
  }

  hr {
    height: 0;
    margin: .5rem 0;
    padding: 0;
    border: 0;
    border-bottom: 2px solid {{css.palette.divider}};
  }

  ol, ul {
    padding-left: 1.5em;
  }

  li {
    line-height: 1.6;
  }

  ul > li {
    list-style-type: disc;
  }

  ol > li {
    list-style-type: decimal;
  }

  blockquote {
    border-left: 4px solid {{css.palette.primary.light}};
    color: rgba(0,0,0,.6);
    padding: .5rem 0 .5rem .5rem;
    margin: .5rem 0;
  }

  code:not(pre > code) {
    /* border-radius: 4px; */
    background-color: rgba(0,0,0,.08);
    padding: .2rem .2rem;
  }

  pre {
    margin: 1rem 0;
    padding: .5rem .7rem;
    white-space: pre-wrap;
    font-size: inherit;
    line-height: 1;
    background-color: #1e1e1e; // = Theme of PrismJS
    border-radius: 4px;
    code {
      font-size: inherit;
      line-height: 1.2;

      &:not([class*="language-"]) {
        color: white;
      }
    }
  }

  details {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    border: dotted 1px;
    margin-bottom: .25rem;
    summary {
      cursor: pointer;
      padding-top: .2rem;
      padding-bottom: .3rem;
      padding-left: .5rem;
      padding-right: .5rem;
    }
    &[open] {
      border-radius: 4px;
      padding-bottom: .5rem;
      & > *:not(summary) {
        margin-left: .5rem;
        margin-right: .5rem;
      }
      /* summary {
        padding-bottom: .2rem;
      }   */
    }
  }

  dd {
    padding-left: 1rem;
    & + dt {
      margin-top: .5rem;
    }
  }

  .note {
    position: relative;
    border: solid 1px {{css.palette.text.primary}};
    border-radius: 4px;
    padding: .5rem .7rem;
    margin: .5rem 0;

    .caption, .title {
      margin: 0 calc(-0.7rem + 8px);
      margin-bottom: .5rem;
      padding: 0 .7rem;
      padding-bottom: .5rem;
      border-bottom: solid 1px {{css.colors.grey.400}};
    }

    &.info {
      border: none;
      /* color: {{css.palette.info.contrast-text}}; */
      background-color: {{css.palette.info.light}};

      .caption, .title {
        color: {{css.palette.info.dark}};
        border-bottom: solid 1px {{css.palette.info.dark}};
      }
    }

    &.warning {
      border: none;
      /* color: {{css.palette.info.contrast-text}}; */
      background-color: {{css.palette.warning.light}};

      .caption, .title {
        color: {{css.palette.warning.dark}};
        border-bottom: solid 1px {{css.palette.warning.dark}};
      }
    }

    &.error {
      border: none;
      /* color: {{css.palette.info.contrast-text}}; */
      background-color: {{css.palette.error.light}};

      .caption, .title {
        color: {{css.palette.error.dark}};
        border-bottom: solid 1px {{css.palette.error.dark}};
      }
    }

    &.reverse {
      border: none;
      background-color: {{css.palette.text.primary}};
      color: {{css.palette.background.default}};

      .caption, .title {
        color: {{css.palette.background.default}};
        border-bottom: solid 1px {{css.palette.background.default}};
      }
    }

    /* &:not(:has(.caption, .title)) {
      padding: .5rem .7rem;
      margin-top: .5rem;
    } */
  }
</style>