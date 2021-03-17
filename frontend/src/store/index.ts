import { AnyAction, createStore } from 'redux'
import { CLEAN_STATE, IUser } from '../interfaces/User.model'

const getUser = JSON.parse(String(localStorage.getItem('user')))

const INITIAL_STATE: IUser = {
  uid: getUser ? getUser.uid : null,
  name: getUser ? getUser.name : '',
  favorites: getUser ? getUser.favorites : [],
  type: getUser ? getUser.type : '',
  gender: getUser ? getUser.gender : '',
  date: getUser ? getUser.date : '',
  email: getUser ? getUser.email : '',
  document: getUser ? getUser.document : '',
  tab: getUser ? getUser.tab : 0,
}

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
      state = CLEAN_STATE
      return state
    case 'SET_TAB':
      localStorage.setItem(
        'user',
        JSON.stringify({ ...state, tab: action.payload })
      )
      return { ...state, tab: action.payload }
    default:
      break
  }
  return state
}

const store = createStore(user)

export default store
