import React, { useEffect, useRef, useState } from 'react'
import './styles.scss'
import logo from '../../assets/logo-icon.svg'
import userIcon from '../../assets/user-icon.svg'
import { Link } from 'react-router-dom'

interface Props {
  condition: boolean
}

interface RefObject<T> {
  // immutable
  readonly current: T | null
}

const Navbar = () => {
  const [condition, setCondition] = useState(false)
  const [modalOpen, setModalOpen] = useState(false)

  const useOutsideClickEvent = (ref: RefObject<any>) => {
    useEffect(() => {
      const handleClickOutside = (event: Event) => {
        if (ref.current && !ref.current.contains(event.target)) {
          console.log(ref)
          setModalOpen(!modalOpen)
        }
      }

      document.addEventListener('mousedown', handleClickOutside)
      return () => {
        document.removeEventListener('mousedown', handleClickOutside)
      }
    }, [ref])
  }

  const UserSettings = () => {
    const wrapperRef = useRef(null)
    useOutsideClickEvent(wrapperRef)

    return (
      <div ref={wrapperRef} className="user-settings">
        <p>Favoritos</p>
        <p>Gerenciar Receitas</p>
        <p>Exibir Perfil</p>
        <Link
          to="/"
          className="log-out"
          onClick={() => {
            setModalOpen(false)
            setCondition(!condition)
          }}
        >
          Logout
        </Link>
      </div>
    )
  }

  const UserControl = ({ condition }: Props) => {
    if (condition) {
      return (
        <div className="auth-wrapper">
          <Link
            to="/"
            className="log-in"
            onClick={() => {
              setCondition(!condition)
            }}
          >
            Log in
          </Link>
          <Link to="/" className="sign-in">
            Sign in
          </Link>
        </div>
      )
    } else {
      return (
        <div className="user-wrapper">
          <div
            className="user"
            onMouseEnter={() => {
              setModalOpen(true)
            }}
            onClick={() => {
              if (!modalOpen) setModalOpen(true)
            }}
          >
            <img src={userIcon} alt="user-icon" />
            <div className="user-info">
              <p>User</p>
              <p>User Type</p>
            </div>
          </div>
          {modalOpen && <UserSettings />}
        </div>
      )
    }
  }

  return (
    <div className="navbar-header-container">
      <Link to="/" className="logo">
        <img src={logo} alt="logo" className="logo-icon" />
        <p>RANDOM KITCHEN</p>
      </Link>
      <div className="search-bar">search</div>
      <UserControl condition={condition} />
    </div>
  )
}

export default Navbar
