import { Route, BrowserRouter } from 'react-router-dom'
import Navbar from './components/Navbar'
import Cadastro from './pages/Cadastro'
import Dashboard from './pages/Dashboard'
import Login from './pages/Login'
import Profile from './pages/Profile'
import Recipe from './pages/Recipe'

const Routes = () => {
  return (
    <BrowserRouter>
      <Navbar />
      <Route component={Dashboard} path="/" exact />
      <Route component={Recipe} path="/recipe/:recipe_id+" />
      <Route component={Login} path="/login" />
      <Route component={Cadastro} path="/sign-in" />
      <Route component={Profile} path="/profile" />
    </BrowserRouter>
  )
}

export default Routes
