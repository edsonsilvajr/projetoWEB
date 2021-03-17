import React, { useState } from 'react'
import './styles.scss'
import receitaImg from '../../assets/receitaImg.png'
import heartIcon from '../../assets/heart-icon.svg'
import heartHover from '../../assets/heart-hover.svg'
import heartFavorite from '../../assets/heart-favorito.svg'
import editIcon from '../../assets/bi_pencil-square.svg'
import deleteIcon from '../../assets/delete-icon.svg'
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
  onDelete?: (number: number) => void
}

function Card({ card, fav, isEditable, isRemovable, onDelete }: Props) {
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

  const deleteRecipe = () => {
    if (onDelete !== undefined) onDelete(card.id)
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
        {user.uid && !isEditable && !isRemovable && (
          <img
            src={handleHover()}
            onMouseEnter={() => setHover(true)}
            onMouseLeave={() => setHover(false)}
            onClick={setFavorites}
            className="heartIcon"
            alt="Icone de favorito"
          />
        )}
        {user.uid && isEditable && isRemovable && (
          <div className="card-options">
            <Link to={`/recipe-edit/${card.id}`}>
              <img src={editIcon} className="heartIcon" alt="Icone de edição" />
            </Link>
            <img
              src={deleteIcon}
              className="heartIcon"
              alt="Icone de Remoção"
              onClick={deleteRecipe}
            />
          </div>
        )}
        {user.uid && !isEditable && isRemovable && (
          <img
            src={deleteIcon}
            className="heartIcon"
            alt="Icone de Remoção"
            onClick={setFavorites}
          />
        )}
      </div>
    </div>
  )
}

export default Card
