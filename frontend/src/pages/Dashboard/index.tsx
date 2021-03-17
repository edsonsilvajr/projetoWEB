import React, { useEffect, useState } from 'react'
import Background from '../../components/Background'
import Card from '../../components/Card'
import './styles.scss'
import api from '../../services/api'
import { useSelector } from 'react-redux'
import { IUser } from '../../interfaces/User.model'
import { ICard } from '../../interfaces/Card.model'
import EventEmitter from '../../utils/EventEmitter'
import { IRecipe } from '../../interfaces/Recipe.model'

const Dashboard = () => {
  const user = useSelector((state) => state) as IUser
  const [cards, setCards] = useState<ICard[]>([])
  useEffect(() => {
    const updateList = (list: IRecipe[]) => {
      setCards(list)
    }
    const listener = EventEmitter.addListener('search', updateList)

    api.get('recipe', { params: { getParam: 2 } }).then((response) => {
      setCards(response.data)
    })

    return () => {
      listener.remove()
    }
  }, [])

  const check = (elementID: number) => {
    if (user) return user.favorites.includes(elementID)
    return false
  }

  return (
    <Background>
      <div className="card-row">
        {cards.map((element) => (
          <Card key={element.id} card={element} fav={check(element.id)} />
        ))}
      </div>
    </Background>
  )
}

export default Dashboard
