
export default class extends React.Component {
  constructor(props) {
    super(props)
    this.state = { hasError: false, error: false }
  }

  static getDerivedStateFromError(error) {
    // Update state so the next render will show the fallback UI.
    return { hasError: true, error }
  }

  componentDidCatch(error, errorInfo) {
    // You can also log the error to an error reporting service
    //logErrorToMyService(error, errorInfo);
  }

  render() {
    if (this.state.hasError) {
      // You can render any custom fallback UI
      const msg = this.state.error instanceof Error ? this.state.error.message : this.state.error
      return React.createElement('div', {
        style: {
          display: 'flex',
          flexDirection: 'column',
          height: '100vh',
          padding: '1rem',
          justifyContent: 'center',
          alignItems: 'center',
          overflowWrap: 'break-word',
          wordBreak: 'break-word',
        },
      }, [
        React.createElement('div', {key:1}, msg),
        React.createElement('div', {
          key:2,
          style: {
            display: 'flex',
            flexDirection: 'column',
            height: '2rem',
            padding: '1rem',
            justifyContent: 'center',
            alignItems: 'center',
            marginTop: '1rem',
            color: 'inherit',
            backgroundColor: 'inherit',
            border: 'solid 1px rgba(0, 0, 0, .1)',
            borderRadius: '2px',
            cursor: 'pointer',
          },
          onClick: e => location.href = '?page=1' // or history.back()
        }, 'BACK'),
      ])
    }

    return this.props.children 
  }
}
