import { Route, BrowserRouter } from 'react-router-dom'
import Navbar from './components/Navbar'
import Dashboard from './pages/Dashboard'

const Routes = () => {
  return (
    <BrowserRouter>
      <Navbar />
      <Route component={Dashboard} path="/" exact />
    </BrowserRouter>
  )
}

export default Routes
