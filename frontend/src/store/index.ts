import { AnyAction, createStore } from 'redux'
import jwt_decode from 'jwt-decode'
import { IUser } from '../interfaces/User.model'

const getUser = localStorage.getItem('user')

const INITIAL_STATE: IUser | null = getUser ? JSON.parse(getUser) : null

//useselector e dispatch

function user(state = INITIAL_STATE, action: AnyAction) {
  switch (action.type) {
    case 'SET_USER':
      localStorage.setItem(
        'user',
        JSON.stringify({ ...state, ...action.payload })
      )
      return { ...state, ...action.payload } as IUser
    case 'DELETE_USER':
      localStorage.removeItem('user')
      localStorage.removeItem('jw_token')
      state = null
      return state
    default:
      break
  }
  return state
}

const store = createStore(user)

export default store
