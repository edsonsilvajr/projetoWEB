import React, { useEffect, useRef, useState } from 'react'
import './styles.scss'
import logo from '../../assets/logo-icon.svg'
import userIcon from '../../assets/user-icon.svg'
import searchIcon from '../../assets/search-icon.svg'
import { Link, useHistory } from 'react-router-dom'
import { useDispatch, useSelector } from 'react-redux'

interface IUser {
  uid: number
  name: string
  type: string
}
interface Props {
  user: IUser
}

interface RefObject<T> {
  // immutable
  readonly current: T | null
}

const Navbar = () => {
  const dispatch = useDispatch()
  const user = useSelector((state) => state)

  const [modalOpen, setModalOpen] = useState(false)

  const useOutsideClickEvent = (ref: RefObject<any>) => {
    useEffect(() => {
      const handleClickOutside = (event: Event) => {
        if (ref.current && !ref.current.contains(event.target)) {
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
        <Link to="/profile" onClick={() => setModalOpen(false)}>
          Exibir Perfil
        </Link>
        <Link
          to="/"
          className="log-out"
          onClick={() => {
            setModalOpen(false)
            localStorage.removeItem('jw_token')
            dispatch({ type: 'DELETE_USER' })
          }}
        >
          Logout
        </Link>
      </div>
    )
  }

  const UserControl = ({ user }: Props) => {
    if (!user) {
      return (
        <div className="auth-wrapper">
          <Link to="/login" className="log-in">
            Log in
          </Link>
          <Link to="/sign-in" className="sign-in">
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
              <p>{user.name}</p>
              <p>{user.type}</p>
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
      <div className="search-bar">
        <input
          type="text"
          className="search"
          placeholder="Busque sua receita"
        />
        <button className="searchButton">
          <img src={searchIcon} alt="Icone de pesquisa" />
        </button>
      </div>
      <UserControl user={user as IUser} />
    </div>
  )
}

export default Navbar
