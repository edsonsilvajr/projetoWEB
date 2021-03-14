import { AnyAction, createStore } from 'redux'
import jwt_decode from 'jwt-decode'
import { IUser } from '../interfaces/User.model'

const token = localStorage.getItem('jw_token')

const INITIAL_STATE: IUser | null = token
  ? (jwt_decode(token as string) as IUser)
  : null

console.log(INITIAL_STATE)

//useselector e dispatch

function user(state = INITIAL_STATE, action: AnyAction) {
  switch (action.type) {
    case 'SET_USER':
      return { ...state, ...action.payload }
    case 'DELETE_USER':
      state = null
      return state
    default:
      break
  }
  return state
}

const store = createStore(user)

export default store
