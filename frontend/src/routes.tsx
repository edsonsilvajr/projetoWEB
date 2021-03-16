import { Route, BrowserRouter } from 'react-router-dom'
import Navbar from './components/Navbar'
import Cadastro from './pages/Cadastro'
import CadastroEdit from './pages/CadastroEdit'
import Dashboard from './pages/Dashboard'
import Login from './pages/Login'
import Profile from './pages/Profile'
import Recipe from './pages/Recipe'
import RecipeAdd from './pages/RecipeAdd'

const Routes = () => {
  return (
    <BrowserRouter>
      <Navbar />
      <Route component={Dashboard} path="/" exact />
      <Route component={Recipe} path="/recipe/:recipe_id+" />
      <Route component={Login} path="/login" />
      <Route component={Cadastro} path="/sign-in" />
      <Route component={Profile} path="/profile" />
      <Route component={CadastroEdit} path="/user/edit" />
      <Route component={RecipeAdd} path="/user/recipe-add" />
    </BrowserRouter>
  )
}

export default Routes
