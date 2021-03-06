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
import EventEmitter from '../../utils/EventEmitter'

function Profile() {
  const user = useSelector((state) => state) as IUser
  const [cards, setCards] = useState<ICard[]>([])
  const [favCards, setFavCards] = useState<ICard[]>([])

  const dispatch = useDispatch()

  const onDelete = (element_id: number) => {
    console.log('caindo aqui ao tirar favorito?')
    api
      .delete('recipe', {
        params: {
          id: element_id,
        },
      })
      .then((res) => {
        api
          .get('recipe', { params: { getParam: 2, id: user.uid } })
          .then((response) => {
            const vetorFiltrado = response.data
            console.log(response)
            setCards(vetorFiltrado)
          })
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
    console.log(user)
    api
      .get('recipe', { params: { getParam: 2, id: user.uid } })
      .then((response) => {
        const vetorFiltrado = response.data
        console.log(response)
        if (isMounted) {
          setCards(vetorFiltrado)
        }
      })
    api
      .get('favorite', {
        params: {
          uid: user.uid,
        },
      })
      .then((res) => {
        console.log(res)
        setFavCards(res.data)
      })
    return () => {
      isMounted = false
    }
  }, [])

  useEffect(() => {
    const listener = EventEmitter.addListener(
      'favoriteRemoved',
      (favorites: any[]) => {
        setFavCards(favorites)
      }
    )
    return () => {
      listener.remove()
    }
  }, [])

  return (
    <Background>
      <div className="containerProfile">
        <div className="saudacoes">
          <h2>Ol?? {user.name}!</h2>
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
                <h2>Perfil do usu??rio</h2>
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
