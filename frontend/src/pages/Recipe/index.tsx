import React, { useEffect, useState } from 'react'
import { useRouteMatch } from 'react-router'
import Background from '../../components/Background'
import './styles.scss'
import api from '../../services/api'
import { IRecipe } from '../../interfaces/Recipe.model'

interface Params {
  recipe_id: string
}

function Recipe() {
  const { params } = useRouteMatch<Params>()
  const [toShow, setToShow] = useState<IRecipe>()

  useEffect(() => {
    api
      .get(`recipe`, {
        params: { getParam: 1, id: params.recipe_id },
      })
      .then((response) => {
        setToShow(response.data)
      })
  }, [])

  return (
    <Background>
      <div className="recipe-container">
        <img src={toShow?.url} className="recipe-img" alt="Imagem receita" />
        <div className="recipe-info">
          <div className="recipe-title-container">
            <h1 className="recipe-title">{toShow?.title}</h1>
            <h2 className="recipe-description">Por: {toShow?.author}</h2>
          </div>
          <div className="recipe-ingredients-container">
            <h1 className="recipe-title">Ingredientes</h1>
            <h2 className="recipe-description">{toShow?.ingredients}</h2>
          </div>
          <div className="recipe-howto-container">
            <h1 className="recipe-title">Modo de preparo</h1>
            <h2 className="recipe-description">{toShow?.preparationMode}</h2>
          </div>
        </div>
      </div>
    </Background>
  )
}

export default Recipe
