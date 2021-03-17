import React from 'react'
import { useSelector } from 'react-redux'
import Background from '../../components/Background'
import CadastroForm from '../../components/CadastroForm'
import { IUser } from '../../interfaces/User.model'

function CadastroEdit() {
  const user = useSelector((state) => state) as IUser
  return (
    <Background background="background-option1 center">
      <CadastroForm isEditable></CadastroForm>
    </Background>
  )
}

export default CadastroEdit
