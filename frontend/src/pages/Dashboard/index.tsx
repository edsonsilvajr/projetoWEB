import React, { useEffect, useState } from 'react'
import Card from '../../components/Card'
import './styles.scss'

interface ICard {
  url: string
  title: string
  description: string
}

const Dashboard = () => {
  const [cards, setCards] = useState<ICard[]>([])
  useEffect(() => {
    const card1 = {
      url:
        'https://diaonline.ig.com.br/wp-content/uploads/2020/07/comida-caseira-brasilia_capa-1024x683.jpg',
      title: 'titulo qualquer',
      description: 'descrição',
    }
    const card2 = {
      url:
        'https://img.itdg.com.br/tdg/images/blog/uploads/2017/07/shutterstock_413580649-300x200.jpg',
      title: 'titulo 2qualquer',
      description: 'descrição2',
    }
    const arrayCards = [card1, card2]
    setCards(arrayCards)
  }, [])

  return (
    <div className="dashboard-container">
      <div className="card-row">
        {cards.map((element) => (
          <Card key={element.title} card={element} />
        ))}
      </div>
    </div>
  )
}

export default Dashboard
