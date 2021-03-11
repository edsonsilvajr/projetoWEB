import React from 'react'
import { Link } from 'react-router-dom'
import Background from '../../components/Background'
import './styles.scss'

//TODO: atribuir dados para os inputs

function Login() {
  return (
    <Background background="background-option1 center">
      <div className="login-container">
        <h1 className="login-title">Login</h1>
        <div className="login-field">
          <label>Email</label>
          <input type="text" />
        </div>
        <div className="login-field">
          <label>Senha</label>
          <input type="text" />
        </div>
        {/* <Link to="/login" className="login-forgot-password">
          Esqueceu sua senha?
        </Link> */}
        <Link to="/" className="login-button">
          Login
        </Link>
      </div>
    </Background>
  )
}

export default Login
