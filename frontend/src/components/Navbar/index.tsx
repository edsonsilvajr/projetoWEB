import React from 'react'
import './styles.scss'
import logo from '../../assets/logo-icon.svg'
import { Link } from 'react-router-dom'

const Navbar = () => {
  const teste = () => {
    console.log('feito')
  }
  return (
    <div className="navbar-header-container">
      <Link to="/" className="logo" onClick={teste}>
        <img src={logo} alt="logo" className="logo-icon" />
        <p>RANDOM KITCHEN</p>
      </Link>
      <div className="search-bar">search</div>
      <div className="auth-wrapper">
        <Link to="/" className="log-in">
          Log in
        </Link>
        <Link to="/" className="sign-in">
          Sign in
        </Link>
      </div>
    </div>
  )
}

export default Navbar
