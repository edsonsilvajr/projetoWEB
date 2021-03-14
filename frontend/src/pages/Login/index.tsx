import axios from 'axios'
import { Formik } from 'formik'
import React, { FormEvent, useState } from 'react'
import { Link, Redirect } from 'react-router-dom'
import Background from '../../components/Background'
import api from '../../services/api'
import './styles.scss'
import * as yup from 'yup'

//TODO: atribuir dados para os inputs

function Login() {
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
              setSubmitting(false)
            },
            (err) => {
              alert(err.response.data.errors)
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
