import React from 'react'
import { Link } from 'react-router-dom'
import Background from '../../components/Background'
import './styles.scss'

function RecipeAdd() {
  return (
    <Background>
      <div className="recipeAdd">
        <h2>Cadastre sua receita</h2>

        <div className="fields">
          <label>Título: </label>
          <input type="text" />
        </div>

        <div className="fields">
          <label>Ingredientes: </label>
          <textarea />
        </div>

        <div className="fields">
          <label>Modo de preparo: </label>
          <textarea />
        </div>

        <div className="fields">
          <label>Imagem: </label>
          <input type="text" placeholder="URL" />
        </div>

        <div className="recipeAddFooter">
          <Link to="/profile">Cancelar</Link>
          <button type="submit">Cadastrar</button>
        </div>
      </div>
    </Background>
  )
}

export default RecipeAdd
