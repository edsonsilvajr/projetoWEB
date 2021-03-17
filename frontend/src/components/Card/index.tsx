import React, { useState } from 'react'
import './styles.scss'
import receitaImg from '../../assets/receitaImg.png'
import heartIcon from '../../assets/heart-icon.svg'
import heartHover from '../../assets/heart-hover.svg'
import heartFavorite from '../../assets/heart-favorito.svg'
import { Link } from 'react-router-dom'
import { ICard } from '../../interfaces/Card.model'
import { IUser } from '../../interfaces/User.model'
import { useDispatch, useSelector } from 'react-redux'
import api from '../../services/api'
interface Props {
  card: ICard
  fav: boolean
  isEditable?: boolean
  isRemovable?: boolean
}

function Card({ card, fav, isEditable, isRemovable }: Props) {
  const user = useSelector((state) => state) as IUser
  const dispatch = useDispatch()

  const [hover, setHover] = useState(false)
  const [favorite, setFavorite] = useState(fav)

  const handleHover = () => {
    if (favorite) {
      return heartFavorite
    }

    if (hover) {
      return heartHover
    }
    return heartIcon
  }

  const setFavorites = () => {
    if (user.favorites.includes(card.id)) {
      user.favorites.splice(user.favorites.indexOf(card.id), 1)
    } else {
      user.favorites.push(card.id)
    }
    api
      .put('user', user, {
        params: { uid: user.uid, getParam: '2' },
      })
      .then((res) => {
        setFavorite(!favorite)
        dispatch({ type: 'SET_USER', payload: user })
      })
  }

  //define se o coração vai existir ou não, pegar futuramente do context API/ Redux

  return (
    <div className="card">
      <Link to={`/recipe/${card.id}`}>
        <img src={card.url} className="receitaImg" alt="Imagem receita" />
      </Link>
      <div className="footerCard">
        <div className="footerLeft">
          <Link to={`/recipe/${card.id}`} className="card-title">
            {card.title}
          </Link>
          <p>{card.description}</p>
        </div>
        {user && !isEditable && !isRemovable && (
          <img
            src={handleHover()}
            onMouseEnter={() => setHover(true)}
            onMouseLeave={() => setHover(false)}
            onClick={setFavorites}
            className="heartIcon"
            alt="Icone de favorito"
          />
        )}
      </div>
    </div>
  )
}

export default Card
