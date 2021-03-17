import React, { useEffect, useState } from 'react'
import Background from '../../components/Background'
import './styles.scss'
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs'
import 'react-tabs/style/react-tabs.css'
import userProfileIcon from '../../assets/user-profile-icon.svg'
import favoriteIcon from '../../assets/heart-icon.svg'
import bookIcon from '../../assets/book-icon.svg'
import { useDispatch, useSelector } from 'react-redux'
import { IUser } from '../../interfaces/User.model'
import { ICard } from '../../interfaces/Card.model'
import api from '../../services/api'
import Card from '../../components/Card'
import { Link } from 'react-router-dom'
import addIcon from '../../assets/add-icon.svg'
import { IRecipe } from '../../interfaces/Recipe.model'

function Profile() {
  const user = useSelector((state) => state) as IUser
  const [cards, setCards] = useState<ICard[]>([])
  const [favCards, setFavCards] = useState<ICard[]>([])

  const dispatch = useDispatch()

  const onDelete = (element_id: number) => {
    console.log('caindo aqui')
    api
      .delete('recipe', {
        params: {
          id: element_id,
        },
      })
      .then((res) => {
        const vetorFiltrado = res.data.filter((element: ICard) => {
          console.log(element.authorid, user.uid)
          return element.authorid === user.uid
        })
        setCards(vetorFiltrado)
        api
          .get('user', {
            params: {
              uid: user.uid,
            },
          })
          .then((res) => {
            dispatch({ type: 'SET_USER', payload: res.data })
          })
      })
  }

  useEffect(() => {
    let isMounted = true
    api.get('recipe', { params: { getParam: 2 } }).then((response) => {
      const vetorFiltrado = response.data.filter((element: ICard) => {
        console.log(element.authorid, user.uid)
        return element.authorid === user.uid
      })
      const vetorFavFiltrado = response.data.filter((element: IRecipe) =>
        user.favorites.includes(element.id)
      )
      if (isMounted) {
        console.log(vetorFiltrado)
        setCards(vetorFiltrado)
        setFavCards(vetorFavFiltrado)
      }
    })
    return () => {
      isMounted = false
    }
  }, [user])

  return (
    <Background>
      <div className="containerProfile">
        <div className="saudacoes">
          <h2>Olá {user.name}!</h2>
        </div>
        <div className="tab">
          <Tabs
            selectedIndex={user.tab}
            onSelect={(index) => {
              dispatch({ type: 'SET_TAB', payload: index })
            }}
          >
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
                  <div>
                    <label>D.Nascimento:</label>
                    <label className="dado">{user.date}</label>
                  </div>
                  <div>
                    <label>Sexo:</label>
                    <label className="dado">
                      {user.gender === 'M' ? 'Masculino' : 'Feminino'}
                    </label>
                  </div>
                </div>
                <div className="divRow">
                  <label>E-mail:</label>
                  <label className="dado">{user.email}</label>
                </div>
                <div className="footerEdit">
                  <Link to="/user/edit" className="buttonEditCadastro">
                    Editar Cadastro
                  </Link>
                </div>
              </div>
            </TabPanel>
            {user.type === 'cozinheiro' && (
              <TabPanel>
                <div className="bgReceitas">
                  <h2>Receitas registradas</h2>
                  <div className="receitas">
                    <button className="newRecipe">
                      <Link to="/user/recipe-add">
                        <img
                          src={addIcon}
                          className="iconAdd"
                          alt="icone para adicionar"
                        />
                        <p>Adicionar receita</p>
                      </Link>
                    </button>
                    {cards.map((element) => (
                      <Card
                        key={element.id}
                        card={element}
                        fav={false}
                        isEditable
                        isRemovable
                        onDelete={onDelete}
                      />
                    ))}
                  </div>
                </div>
              </TabPanel>
            )}
            <TabPanel>
              <div className="bgReceitas">
                <h2>Receitas favoritas</h2>
                <div className="receitas">
                  {favCards.map((element) => (
                    <Card
                      key={element.id}
                      card={element}
                      fav={true}
                      isRemovable
                    />
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
