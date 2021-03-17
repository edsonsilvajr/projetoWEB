import React, { useEffect, useState } from 'react'
import { Link, useHistory } from 'react-router-dom'
import { IRecipe } from '../../interfaces/Recipe.model'
import './styles.scss'
import * as yup from 'yup'
import { Formik } from 'formik'
import api from '../../services/api'
import { useSelector } from 'react-redux'
import { IUser } from '../../interfaces/User.model'

interface Props {
  isEditable?: boolean
  recipeId?: number
}
function RecipeForm({ isEditable, recipeId }: Props) {
  const user = useSelector((state) => state) as IUser
  const [form, setForm] = useState<any>({
    id: null,
    title: '',
    description: '',
    ingredients: '',
    preparationMode: '',
    url: '',
    authorid: '',
    author: '',
  })

  const history = useHistory()

  useEffect(() => {
    let mounted = true
    if (recipeId) {
      api
        .get('recipe', {
          params: {
            getParam: 1,
            id: recipeId,
          },
        })
        .then((res) => {
          if (mounted) {
            console.log('entrou aqui')
            setForm({
              id: res.data.id,
              title: res.data.title,
              description: res.data.description,
              ingredients: res.data.ingredients,
              preparationMode: res.data.preparationMode,
              url: res.data.url,
              authorid: user.uid,
              author: user.name,
            })
          }
        })
    }

    return () => {
      mounted = false
    }
  }, [recipeId])

  const recipeSchema = yup.object().shape({
    title: yup.string().required(),
    ingredients: yup.string().required(),
    preparationMode: yup.string().required(),
    description: yup.string().required(),
    url: yup.string().required(),
  })

  return (
    <Formik
      enableReinitialize
      initialValues={form}
      validationSchema={recipeSchema}
      onSubmit={(values, { setSubmitting, setStatus }) => {
        if (!isEditable) {
          api.post('recipe', values).then((res) => {
            console.log(res)
            history.push('/profile')
          })
        } else {
          api
            .put('recipe', values, {
              params: {
                id: recipeId,
              },
            })
            .then((res) => {
              console.log(res)
              history.push('/profile')
            })
        }
      }}
    >
      {({
        values,
        errors,
        touched,
        handleChange,
        handleBlur,
        handleSubmit,
        isSubmitting,
      }) => (
        <form className="recipeAdd" method="post" onSubmit={handleSubmit}>
          <h2>
            {(isEditable && 'Edite') || (!isEditable && 'Cadastre')} sua receita
          </h2>

          <div className="fields">
            <label>Título: </label>
            <input
              type="text"
              name="title"
              value={values.title}
              onChange={handleChange}
              onBlur={handleBlur}
            />
            <div className="error">
              {errors.title && touched.title && errors.title}
            </div>
          </div>

          <div className="fields">
            <label>Ingredientes: </label>
            <textarea
              name="ingredients"
              value={values.ingredients}
              onChange={handleChange}
              onBlur={handleBlur}
            />
            <div className="error">
              {errors.ingredients && touched.ingredients && errors.ingredients}
            </div>
          </div>

          <div className="fields">
            <label>Modo de preparo: </label>
            <textarea
              name="preparationMode"
              value={values.preparationMode}
              onChange={handleChange}
              onBlur={handleBlur}
            />
            <div className="error">
              {errors.preparationMode &&
                touched.preparationMode &&
                errors.preparationMode}
            </div>
          </div>

          <div className="fields">
            <label>Descrição: </label>
            <textarea
              name="description"
              value={values.description}
              onChange={handleChange}
              onBlur={handleBlur}
            />
            <div className="error">
              {errors.description && touched.description && errors.description}
            </div>
          </div>

          <div className="fields">
            <label>Imagem: </label>
            <input
              type="text"
              placeholder="URL"
              name="url"
              value={values.url}
              onChange={handleChange}
              onBlur={handleBlur}
            />
            <div className="error">
              {errors.url && touched.url && errors.url}
            </div>
          </div>

          <div className="recipeAddFooter">
            <Link to="/profile">Cancelar</Link>
            <button type="submit">Cadastrar</button>
          </div>
        </form>
      )}
    </Formik>
  )
}

export default RecipeForm
