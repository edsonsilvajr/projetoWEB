import React from 'react'
import { useRouteMatch } from 'react-router'
import Background from '../../components/Background'
import './styles.scss'

//importando MOCK
import { arrayCards } from './data'

interface Params {
  recipe_id: string
}

function Recipe() {
  const { params } = useRouteMatch<Params>()

  const toShow = arrayCards.find(
    (element) => element.recipe_id === params.recipe_id
  )

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
