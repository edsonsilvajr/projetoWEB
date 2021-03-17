import React, { useEffect, useState } from 'react'
import { useRouteMatch } from 'react-router-dom'
import Background from '../../components/Background'
import RecipeForm from '../../components/RecipeForm'
import { IRecipe } from '../../interfaces/Recipe.model'
import api from '../../services/api'
import './styles.scss'

interface Params {
  recipe_id: string
}

function RecipeEdit() {
  const { params } = useRouteMatch<Params>()
  const [toEdit, setToEdit] = useState<IRecipe>()

  useEffect(() => {
    console.log(params)
    let isMounted = true
    api
      .get('recipe', {
        params: {
          getParam: 1,
          id: params.recipe_id,
        },
      })
      .then((res) => {
        if (isMounted) {
          setToEdit(res.data)
        }
      })
    return () => {
      isMounted = false
    }
  }, [])

  return (
    <Background>
      <RecipeForm isEditable recipe={toEdit} />
    </Background>
  )
}

export default RecipeEdit
