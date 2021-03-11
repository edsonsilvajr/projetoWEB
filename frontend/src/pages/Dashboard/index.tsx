import React, { useEffect, useState } from 'react'
import Background from '../../components/Background'
import Card from '../../components/Card'
import './styles.scss'

//importing MOCK
import { arrayCards } from './data'

interface ICard {
  url: string
  title: string
  description: string
}

const Dashboard = () => {
  const [cards, setCards] = useState<ICard[]>(arrayCards)

  return (
    <Background>
      <div className="card-row">
        {cards.map((element) => (
          <Card key={element.title} card={element} />
        ))}
      </div>
    </Background>
  )
}

export default Dashboard
