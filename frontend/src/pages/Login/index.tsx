import axios from 'axios'
import React, { FormEvent, useState } from 'react'
import { Link } from 'react-router-dom'
import Background from '../../components/Background'
import api from '../../services/api'
import './styles.scss'

//TODO: atribuir dados para os inputs

interface IUserLogin {
  email: string
  password: string
}

function Login() {
  const [user, setUser] = useState<IUserLogin>({
    email: '',
    password: '',
  })

  const login = (e: FormEvent) => {
    e.preventDefault()
    api.post('auth', user)
    api.post('auth', user).then((res) => {
      const data = res.data.data
      localStorage.setItem('jw_token', data.token)
    })
  }

  /* const teste = async () => {
    const res = await api.get('auth')
  }
  teste() */
  return (
    <Background background="background-option1 center">
      <form className="login-container" onSubmit={login}>
        <h1 className="login-title">Login</h1>
        <div className="login-field">
          <label>Email</label>
          <input
            type="text"
            onChange={(e) => setUser({ ...user, email: e.target.value })}
          />
        </div>
        <div className="login-field">
          <label>Senha</label>
          <input
            type="text"
            onChange={(e) => setUser({ ...user, password: e.target.value })}
          />
        </div>
        {/* <Link to="/login" className="login-forgot-password">
          Esqueceu sua senha?
        </Link> */}
        {/* <Link to="/" className="login-button">
          Login
        </Link> */}
        <button type="submit" className="login-button">
          Login
        </button>
      </form>
    </Background>
  )
}

export default Login
