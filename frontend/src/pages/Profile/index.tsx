import React, { useEffect, useState } from 'react'
import Background from '../../components/Background'
import './styles.scss'
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs'
import 'react-tabs/style/react-tabs.css'
import userProfileIcon from '../../assets/user-profile-icon.svg'
import favoriteIcon from '../../assets/heart-icon.svg'
import bookIcon from '../../assets/book-icon.svg'
import { useSelector } from 'react-redux'
import { IUser } from '../../interfaces/User.model'
import { ICard } from '../../interfaces/Card.model'
import api from '../../services/api'
import Card from '../../components/Card'

function Profile() {
  const user = useSelector((state) => state) as IUser
  const [cards, setCards] = useState<ICard[]>([])
  useEffect(() => {
    api.get('recipe', { params: { getParam: 2 } }).then((response) => {
      const vetorFiltrado = response.data.filter(
        (element: ICard) => element.authorid === user.uid
      )
      setCards(vetorFiltrado)
    })
  }, [])

  return (
    <Background>
      <div className="containerProfile">
        <div className="saudacoes">
          <h2>Olá {user.name}!</h2>
        </div>
        <div className="tab">
          <Tabs defaultIndex={1}>
            <TabList>
              <Tab>
                <img src={userProfileIcon} alt="Icone de usuario" />
              </Tab>
              {user.type === 'cozinheiro' && (
                <Tab>
                  <img src={bookIcon} alt="Icone de receitas" />
                </Tab>
              )}
              <Tab>
                <img src={favoriteIcon} alt="Icone de favoritos" />
              </Tab>
            </TabList>

            <TabPanel>
              <div className="profileUser">
                <h2>Perfil do usuário</h2>
                <div className="divRow">
                  <label>Nome:</label>
                  <label className="dado">{user.name}</label>
                </div>
                <div className="middleContainerProfile">
                  <div className="leftSideProfile">
                    <label>D.Nascimento:</label>
                    <label className="dado">12/12/12</label>
                  </div>
                  <div className="rightSideProfile">
                    <label>Sexo:</label>
                    <label className="dado">Masculino</label>
                  </div>
                </div>
                <div className="divRow">
                  <label>E-mail:</label>
                  <label className="dado">vine@vine.com</label>
                </div>
                <div className="footerEdit">
                  <button className="buttonEditCadastro">
                    Editar Cadastro
                  </button>
                </div>
              </div>
            </TabPanel>
            {user.type === 'cozinheiro' && (
              <TabPanel>
                <div className="bgReceitas">
                  <h2>Receitas registradas</h2>
                  <div className="receitas">
                    {cards.map((element) => (
                      <Card key={element.id} card={element} fav={false} />
                    ))}
                  </div>
                </div>
              </TabPanel>
            )}
            <TabPanel>
              <div className="bgReceitas">
                <h2>Receitas favoritas</h2>
                <div className="receitas">
                  {cards.map((element) => (
                    <Card key={element.id} card={element} fav={true} />
                  ))}
                </div>
              </div>
            </TabPanel>
          </Tabs>
        </div>
      </div>
    </Background>
  )
}

export default Profile
