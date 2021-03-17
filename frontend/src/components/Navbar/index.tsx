import React, { KeyboardEvent, useEffect, useRef, useState } from 'react'
import './styles.scss'
import logo from '../../assets/logo-icon.svg'
import userIcon from '../../assets/user-icon.svg'
import searchIcon from '../../assets/search-icon.svg'
import { Link, useHistory } from 'react-router-dom'
import { useDispatch, useSelector } from 'react-redux'
import EventEmitter from '../../utils/EventEmitter'
import api from '../../services/api'

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
  const user = useSelector((state) => state) as IUser

  const [modalOpen, setModalOpen] = useState(false)
  const [inputValue, setInputValue] = useState<string>()

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
            dispatch({ type: 'DELETE_USER' })
          }}
        >
          Logout
        </Link>
      </div>
    )
  }

  const handleKeyEvent = (event: KeyboardEvent) => {
    if (event.key === 'Enter') search()
  }

  const search = () => {
    if (inputValue) {
      api
        .get('recipe', {
          params: {
            getParam: 3,
            title: inputValue,
          },
        })
        .then((res) => {
          EventEmitter.emit('search', res.data)
        })
    } else {
      api
        .get('recipe', {
          params: {
            getParam: 2,
          },
        })
        .then((res) => {
          EventEmitter.emit('search', res.data)
        })
    }
  }

  const UserControl = ({ user }: Props) => {
    if (!user.uid) {
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
          onChange={(e) => setInputValue(e.target.value)}
          onKeyDown={handleKeyEvent}
        />
        <button className="searchButton" onClick={search}>
          <img src={searchIcon} alt="Icone de pesquisa" />
        </button>
      </div>
      <UserControl user={user} />
    </div>
  )
}

export default Navbar
