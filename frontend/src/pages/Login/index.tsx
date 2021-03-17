import { Formik } from 'formik'
import React from 'react'
import { Link, useHistory } from 'react-router-dom'
import Background from '../../components/Background'
import api from '../../services/api'
import { useDispatch } from 'react-redux'
import './styles.scss'
import * as yup from 'yup'
import { ToastContainer, toast } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'
import jwt_decode from 'jwt-decode'

//TODO: atribuir dados para os inputs

function Login() {
  const dispatch = useDispatch()
  const history = useHistory()
  const userSchema = yup.object().shape({
    email: yup.string().email().required(),
    password: yup.string().required(),
  })

  return (
    <Background background="background-option1 center">
      <Formik
        initialValues={{ email: '', password: '' }}
        validationSchema={userSchema}
        onSubmit={(values, { setSubmitting }) => {
          api.post('auth', values).then(
            (res) => {
              const data = res.data.data
              localStorage.setItem('jw_token', data.token)
              localStorage.setItem('user', data.user)
              setSubmitting(false)
              dispatch({ type: 'SET_USER', payload: data.user })
              history.push('/')
              setTimeout(() => {
                toast.success('👨‍🍳 ' + 'Logado com sucesso!', {
                  position: 'top-center',
                  autoClose: 2000,
                  hideProgressBar: false,
                  closeOnClick: true,
                  pauseOnHover: true,
                  draggable: true,
                  progress: undefined,
                })
              })
            },
            (err) => {
              toast.error('👨‍🍳 ' + err.response.data.errors, {
                position: 'top-center',
                autoClose: 2000,
                hideProgressBar: false,
                closeOnClick: true,
                pauseOnHover: true,
                draggable: true,
                progress: undefined,
              })
            }
          )
        }}
      >
        {({
          values,
          errors,
          touched,
          handleChange,
          handleBlur,
          handleSubmit,
          isSubmitting,
        }) => (
          <form onSubmit={handleSubmit} className="login-container">
            <h1 className="login-title">Login</h1>
            <div className="login-field">
              <label>Email</label>
              <input
                type="email"
                name="email"
                onChange={handleChange}
                onBlur={handleBlur}
                value={values.email}
              />
              <div>
                {errors.email && touched.email && errors.email && (
                  <p>* Insira um email válido</p>
                )}
              </div>
            </div>
            <div className="login-field">
              <label>Senha</label>
              <input
                type="password"
                name="password"
                onChange={handleChange}
                onBlur={handleBlur}
                value={values.password}
              />
              <div>
                {errors.password && touched.password && errors.password && (
                  <p>* A senha é um campo obrigatório</p>
                )}
              </div>
            </div>
            <button type="submit" className="login-button">
              Login
            </button>
          </form>
        )}
      </Formik>
    </Background>
  )
}

export default Login
