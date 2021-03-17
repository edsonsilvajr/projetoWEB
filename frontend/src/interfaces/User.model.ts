export interface IUser {
  uid: number | null
  name: string
  favorites: number[]
  type: string
  gender: string
  date: string
  email: string
  document: string
  tab?: number
}

export const CLEAN_STATE: IUser = {
  uid: null,
  name: '',
  favorites: [],
  type: '',
  gender: '',
  date: '',
  email: '',
  document: '',
  tab: 0,
}
