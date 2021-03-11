import React, { useState } from 'react'
import './styles.scss'
import receitaImg from '../../assets/receitaImg.png'
import heartIcon from '../../assets/heart-icon.svg'
import heartHover from '../../assets/heart-hover.svg'
import heartFavorite from '../../assets/heart-favorito.svg'
import { Link } from 'react-router-dom'

interface Card {
  url: string
  title: string
  description: string
}

interface Props {
  card: Card
}

function Card({ card }: Props) {
  const [hover, setHover] = useState(false)
  const [favorite, setFavorite] = useState(false)
  const handleHover = () => {
    if (favorite) {
      return heartFavorite
    }

    if (hover) {
      return heartHover
    }
    return heartIcon
  }

  return (
    <div className="card">
      <img src={card.url} className="receitaImg" alt="Imagem receita" />
      <div className="footerCard">
        <div className="footerLeft">
          <Link to={`/recipe/${card.title}`} className="card-title">
            {card.title}
          </Link>
          <p>{card.description}</p>
        </div>
        <img
          src={handleHover()}
          onMouseEnter={() => setHover(true)}
          onMouseLeave={() => setHover(false)}
          onClick={() => setFavorite(!favorite)}
          className="heartIcon"
          alt="Icone de favorito"
        />
      </div>
    </div>
  )
}

export default Card
