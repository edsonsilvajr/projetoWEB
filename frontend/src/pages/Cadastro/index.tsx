import React from 'react'
import Background from '../../components/Background'
import './styles.scss'

function Cadastro() {
    return (
    <Background background="background-option1 center">
      <div className="containerCadastro">
        <h1>Cadastro</h1>
        <div className="typeContainer">
          <label>Selecione um tipo de cadastro: </label>
          <select name="typeUser" id="type">
            <option value="batata">Batata</option>
            <option value="cozinheiro">Cozinheiro</option>
          </select>
        </div>
        <div className="fieldContainer">
          <label>Nome:</label>
          <input type="text" className="txtName" />
        </div>
        <div className="fieldContainer">
          <label>CPF:</label>
          <input type="text" className="txtCPF" />
        </div>
        <div className="middleContainer">
          <div className="leftSide">
            <label>D.Nascimento:</label>
            <input type="date" className="nasc" />
          </div>
          <div className="rightSide">
            <label>Sexo:</label>
            <input type="radio" value="Male" name="gender" /> <span>M</span>
            <input type="radio" value="Female" name="gender" /> <span>F</span>
          </div>
        </div>
        <div className="fieldContainer">
          <label>E-mail:</label>
          <input type="text" className="email" />
        </div>
        <div className="fieldContainer">
          <label>Senha:</label>
          <input type="text" className="senha" />
        </div>
        <div className="fieldContainer">
          <button>Cancelar</button>
          <button>Cadastrar</button>
        </div>
      </div>
    </Background>
  )
}

export default Cadastro
