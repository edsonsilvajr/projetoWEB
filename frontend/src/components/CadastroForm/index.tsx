import { Field, Formik } from 'formik'
import React from 'react'
import api from '../../services/api'
import './styles.scss'
import * as yup from 'yup'
import { useHistory } from 'react-router'
import { Link } from 'react-router-dom'
import { toast } from 'react-toastify'
import { IUser } from '../../interfaces/User.model'
import { useDispatch, useSelector } from 'react-redux'
import { toastDefaultConfig } from '../../utils/toast.config'

interface Props {
  isEditable?: boolean
}
function CadastroForm({ isEditable }: Props) {
  const dispatch = useDispatch()
  const user = useSelector((state) => state) as IUser

  const history = useHistory()

  const userSchema = !isEditable
    ? yup.object().shape({
        name: yup.string().required('* Nome é obrigatório!'),
        type: yup.string().required(),
        password: yup.string().required('* A senha é obrigatória!'),
        gender: yup.string().required('* Gênero é obrigatório!'),
        date: yup.string().required('* A data de nascimento é obrigatória!'),
        email: yup.string().email().required('* O email é obrigatório!'),
        document: yup.string().when('type', {
          is: 'cozinheiro',
          then: yup
            .string()
            .required('* O documento (quando cozinheiro) é obrigatório!'),
        }),
      })
    : yup.object().shape({
        name: yup.string().required('* Nome é obrigatório!'),
        type: yup.string().required(),
        gender: yup.string().required('* Gênero é obrigatório!'),
        date: yup.string().required('* A data de nascimento é obrigatória!'),
        email: yup.string().email().required('* O email é obrigatório!'),
        document: yup.string().when('type', {
          is: 'cozinheiro',
          then: yup
            .string()
            .required('* O documento (quando cozinheiro) é obrigatório!'),
        }),
      })

  return (
    <Formik
      initialValues={{
        uid: user?.uid || null,
        name: user?.name || '',
        type: user?.type || 'aprendiz',
        password: '',
        gender: user?.gender || '',
        date: user?.date || '',
        email: user?.email || '',
        document: user?.document || '',
      }}
      validationSchema={userSchema}
      onSubmit={(values, { setSubmitting, setStatus }) => {
        if (!user.uid) {
          api.post('user', values).then(
            //Adding user
            (res) => {
              toast.success(
                '👨‍🍳 ' + 'Usuário cadastrado com sucesso!',
                toastDefaultConfig
              )
              history.push('/')
            },
            (err) => {
              toast.error('👨‍🍳 ' + err.response.data.errors, toastDefaultConfig)
            }
          )
        } else {
          // Editing user
          api
            .put('user', values, {
              params: {
                getParam: 1,
                uid: user.uid,
              },
            })
            .then((res) => {
              toast.success('👨‍🍳 ' + res.data.message, {
                position: 'top-center',
                autoClose: 2000,
                hideProgressBar: false,
                closeOnClick: true,
                pauseOnHover: true,
                draggable: true,
                progress: undefined,
              })
              dispatch({ type: 'SET_USER', payload: res.data.data })
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
        <form
          method="post"
          className="containerCadastro"
          onSubmit={handleSubmit}
        >
          <h1>{user.uid && 'Editar '}Cadastro</h1>
          <div className="typeContainer">
            <label>Selecione um tipo de cadastro: </label>
            <Field as="select" name="type" id="type" value={values.type}>
              <option value="aprendiz">Aprendiz</option>
              <option value="cozinheiro">Cozinheiro</option>
            </Field>
          </div>
          <div className="fieldContainer">
            <label>Nome:</label>
            <input
              type="text"
              name="name"
              className="txtName"
              onChange={handleChange}
              onBlur={handleBlur}
              value={values.name}
            />
            <div className="error">
              {errors.name && touched.name && errors.name}
            </div>
          </div>
          <div className="middleContainer">
            <div className="leftSide">
              <label>D.Nascimento:</label>
              <input
                type="date"
                className="nasc"
                name="date"
                value={values.date}
                onChange={handleChange}
                onBlur={handleBlur}
              />
              <div className="error">
                {errors.date && touched.date && errors.date}
              </div>
            </div>
            <div className="rightSide">
              <label>Sexo:</label>
              <Field type="radio" value="M" name="gender" /> <span>M</span>
              <Field type="radio" value="F" name="gender" /> <span>F</span>
              <div className="error">
                {errors.gender && touched.gender && errors.gender}
              </div>
            </div>
          </div>
          <div className="fieldContainer">
            <label>E-mail:</label>
            <input
              type="email"
              name="email"
              className="email"
              value={values.email}
              onChange={handleChange}
              onBlur={handleBlur}
            />
            <div className="error">
              {errors.email && touched.email && errors.email}
            </div>
          </div>
          {!user.uid && (
            <div className="fieldContainer">
              <label>Senha:</label>
              <input
                type="password"
                name="password"
                className="senha"
                value={values.password}
                onChange={handleChange}
                onBlur={handleBlur}
              />
              <div className="error">
                {errors.password && touched.password && errors.password}
              </div>
            </div>
          )}
          {values.type === 'cozinheiro' && (
            <div className="fieldContainer">
              <label>Documento do Cozinheiro:</label>
              <input
                type="text"
                className="senha"
                name="document"
                value={values.document}
                onChange={handleChange}
                onBlur={handleBlur}
              />
              <div className="error">
                {errors.document && touched.document && errors.document}
              </div>
            </div>
          )}
          <div className="fieldContainer">
            <Link
              to={() => {
                return user.uid ? '/profile' : '/'
              }}
            >
              Cancelar
            </Link>
            <button type="submit">Cadastrar</button>
          </div>
        </form>
      )}
    </Formik>
  )
}

export default CadastroForm
