import React from 'react'
import { useRouteMatch } from 'react-router-dom'
import Background from '../../components/Background'
import RecipeForm from '../../components/RecipeForm'
import './styles.scss'

interface Params {
  recipe_id: string
}

function RecipeEdit() {
  const { params } = useRouteMatch<Params>()

  return (
    <Background>
      <RecipeForm isEditable recipeId={+params.recipe_id} />
    </Background>
  )
}

export default RecipeEdit
