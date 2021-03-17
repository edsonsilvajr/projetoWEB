import React, { createElement } from 'react'
import { Route, BrowserRouter, Redirect } from 'react-router-dom'
import { ToastContainer } from 'react-toastify'
import Navbar from './components/Navbar'
import Cadastro from './pages/Cadastro'
import CadastroEdit from './pages/CadastroEdit'
import Dashboard from './pages/Dashboard'
import Login from './pages/Login'
import Profile from './pages/Profile'
import Recipe from './pages/Recipe'
import RecipeAdd from './pages/RecipeAdd'
import RecipeEdit from './pages/RecipeEdit'

const Routes = () => {
  const PrivateRoute = ({ component, ...rest }: any) => {
    return (
      <Route
        {...rest}
        render={(props) =>
          localStorage.getItem('user') ? (
            createElement(component, props)
          ) : (
            <Redirect
              to={{
                pathname: '/',
                state: {
                  from: props.location,
                },
              }}
            />
          )
        }
      />
    )
  }
  return (
    <BrowserRouter>
      <Navbar />
      <ToastContainer limit={1} />
      <Route component={Dashboard} path="/" exact />
      <Route component={Recipe} path="/recipe/:recipe_id+" />
      <Route component={Login} path="/login" />
      <Route component={Cadastro} path="/sign-in" />
      <PrivateRoute component={Profile} path="/profile" />
      <PrivateRoute component={CadastroEdit} path="/user/edit" />
      <PrivateRoute component={RecipeAdd} path="/user/recipe-add" />
      <PrivateRoute component={RecipeEdit} path="/recipe-edit/:recipe_id+" />
    </BrowserRouter>
  )
}

export default Routes
