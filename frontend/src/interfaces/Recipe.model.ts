export interface IRecipe {
  id: number
  author: string
  authorid: number
  title: string
  url: string
  description: string
  ingredients: string
  preparationMode: string
  category: string
}

export const categories = ['carnes', 'bolos']
