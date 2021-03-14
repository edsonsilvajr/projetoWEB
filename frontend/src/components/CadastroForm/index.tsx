import React, { FormEvent, useState } from 'react'
import api from '../../services/api'
import './styles.scss'

interface User {
  uid?: number | null
  name: string
  type: string
  password: string
  gender: string
  date: string
  email: string
  document?: string | null
}
function CadastroForm() {
  const [user, setUser] = useState<User>({
    uid: null,
    name: '',
    type: '',
    password: '',
    gender: '',
    date: '',
    email: '',
    document: null,
  })

  const sendForm = (e: FormEvent) => {
    e.preventDefault()
    api.post('user', user).then((res) => {
      console.log(res)
    })
  }
  return (
    <form method="post" className="containerCadastro" onSubmit={sendForm}>
      <h1>Cadastro</h1>
      <div className="typeContainer">
        <label>Selecione um tipo de cadastro: </label>
        <select
          name="typeUser"
          id="type"
          onChange={(e) => setUser({ ...user, type: e.target.value })}
        >
          <option value="batata">Batata</option>
          <option value="cozinheiro">Cozinheiro</option>
        </select>
      </div>
      <div className="fieldContainer">
        <label>Nome:</label>
        <input
          type="text"
          className="txtName"
          onChange={(e) => setUser({ ...user, name: e.target.value })}
        />
      </div>
      <div className="middleContainer">
        <div className="leftSide">
          <label>D.Nascimento:</label>
          <input
            type="date"
            className="nasc"
            onChange={(e) => setUser({ ...user, date: e.target.value })}
          />
        </div>
        <div
          className="rightSide"
          onChange={(e) => {
            setUser({ ...user, gender: (e.target as HTMLInputElement).value })
          }}
        >
          <label>Sexo:</label>
          <input type="radio" value="M" name="gender" /> <span>M</span>
          <input type="radio" value="F" name="gender" /> <span>F</span>
        </div>
      </div>
      <div className="fieldContainer">
        <label>E-mail:</label>
        <input
          type="text"
          className="email"
          onChange={(e) => setUser({ ...user, email: e.target.value })}
        />
      </div>
      <div className="fieldContainer">
        <label>Senha:</label>
        <input
          type="password"
          className="senha"
          onChange={(e) => setUser({ ...user, password: e.target.value })}
        />
      </div>
      {user.type === 'cozinheiro' && (
        <div className="fieldContainer">
          <label>Documento do Cozinheiro:</label>
          <input
            type="text"
            className="senha"
            onChange={(e) => setUser({ ...user, document: e.target.value })}
          />
        </div>
      )}
      <div className="fieldContainer">
        <button>Cancelar</button>
        <button type="submit">Cadastrar</button>
      </div>
    </form>
  )
}

export default CadastroForm
