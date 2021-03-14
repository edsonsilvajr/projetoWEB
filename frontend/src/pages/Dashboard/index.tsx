import React, { useEffect, useState } from 'react'
import Background from '../../components/Background'
import Card from '../../components/Card'
import './styles.scss'
import api from '../../services/api'

interface ICard {
  id: number
  url: string
  title: string
  description: string
}

const Dashboard = () => {
  const [cards, setCards] = useState<ICard[]>([])

  useEffect(() => {
    api.get('recipe', { params: { getParam: 2 } }).then((response) => {
      setCards(response.data)
    })
  }, [])

  return (
    <Background>
      <div className="card-row">
        {cards.map((element) => (
          <Card key={element.id} card={element} />
        ))}
      </div>
    </Background>
  )
}

export default Dashboard
