interface Recipe {
  recipe_id: string
  author: string
  url: string
  title: string
  description: string
  ingredients: string
  preparationMode: string
}

const card1: Recipe = {
  recipe_id: 'titulo qualquer',
  author: 'Edson Luiz da Silva Junior',
  url:
    'https://diaonline.ig.com.br/wp-content/uploads/2020/07/comida-caseira-brasilia_capa-1024x683.jpg',
  title: 'titulo qualquer',
  description: 'descrição2',
  ingredients:
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Turpis egestas maecenas pharetra convallis posuere morbi. Nulla facilisi morbi tempus iaculis. Nulla facilisi etiam dignissim diam quis enim lobortis scelerisque. Massa tincidunt dui ut ornare lectus sit amet est placerat. Semper risus in hendrerit gravida rutrum. Volutpat maecenas volutpat blandit aliquam. Vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam. Dolor sit amet consectetur adipiscing. Proin nibh nisl condimentum id venenatis a. Suspendisse ultrices gravida dictum fusce ut. Lorem mollis aliquam ut porttitor. Id faucibus nisl tincidunt eget nullam non nisi. Sed ullamcorper morbi tincidunt ornare massa. Vel elit scelerisque mauris pellentesque. Cursus vitae congue mauris rhoncus aenean vel elit scelerisque. Morbi tincidunt ornare massa eget egestas purus viverra accumsan in. Pellentesque adipiscing commodo elit at imperdiet dui accumsan. Faucibus vitae aliquet nec ullamcorper sit. Vel risus commodo viverra maecenas accumsan.',
  preparationMode:
    'A diam sollicitudin tempor id. Metus aliquam eleifend mi in. Nibh nisl condimentum id venenatis. Facilisi morbi tempus iaculis urna id volutpat lacus. Odio tempor orci dapibus ultrices in iaculis nunc sed. Imperdiet dui accumsan sit amet nulla facilisi morbi tempus. Id neque aliquam vestibulum morbi blandit cursus risus at. Eget nullam non nisi est. Maecenas volutpat blandit aliquam etiam erat velit scelerisque. Non quam lacus suspendisse faucibus interdum. Consequat ac felis donec et odio pellentesque diam volutpat. At lectus urna duis convallis convallis tellus id interdum velit. Tincidunt ornare massa eget egestas. Blandit volutpat maecenas volutpat blandit. Suspendisse interdum consectetur libero id faucibus nisl tincidunt. Aliquam nulla facilisi cras fermentum odio eu feugiat pretium. Urna cursus eget nunc scelerisque viverra mauris in. Ac turpis egestas sed tempus urna et. Enim blandit volutpat maecenas volutpat blandit. Vel orci porta non pulvinar neque laoreet.',
}
const card2: Recipe = {
  recipe_id: 'titulo 2qualquer',
  author: 'David Pavlak',
  url:
    'https://img.itdg.com.br/tdg/images/blog/uploads/2017/07/shutterstock_413580649-300x200.jpg',
  title: 'titulo 2qualquer',
  description: 'descrição2',
  ingredients:
    'Commodo odio aenean sed adipiscing diam donec. In massa tempor nec feugiat nisl pretium. Quam quisque id diam vel quam elementum pulvinar. Arcu dictum varius duis at consectetur. Fermentum et sollicitudin ac orci phasellus. Cum sociis natoque penatibus et magnis dis. Odio pellentesque diam volutpat commodo sed egestas. Euismod nisi porta lorem mollis aliquam ut porttitor leo a. Vel pretium lectus quam id leo in vitae. Mattis molestie a iaculis at erat pellentesque adipiscing. Quam id leo in vitae. Eu augue ut lectus arcu bibendum at varius. Eros in cursus turpis massa tincidunt. Hac habitasse platea dictumst quisque. Pretium lectus quam id leo in vitae. Nunc aliquet bibendum enim facilisis gravida. Vivamus at augue eget arcu dictum varius. Ut eu sem integer vitae justo eget magna fermentum. Neque laoreet suspendisse interdum consectetur libero id faucibus nisl tincidunt. Massa placerat duis ultricies lacus sed turpis tincidunt id aliquet.',
  preparationMode:
    'Nunc scelerisque viverra mauris in. Quam adipiscing vitae proin sagittis. Molestie nunc non blandit massa enim nec dui nunc mattis. Faucibus purus in massa tempor nec feugiat nisl. Pulvinar neque laoreet suspendisse interdum consectetur libero id. Gravida quis blandit turpis cursus. Risus quis varius quam quisque id. Hac habitasse platea dictumst quisque sagittis purus sit amet volutpat. Fermentum dui faucibus in ornare. Nulla facilisi nullam vehicula ipsum a arcu cursus vitae. Curabitur gravida arcu ac tortor dignissim convallis aenean. Vitae tortor condimentum lacinia quis vel eros. Sit amet luctus venenatis lectus. Arcu felis bibendum ut tristique et. Senectus et netus et malesuada fames ac turpis egestas. Sit amet nisl suscipit adipiscing bibendum. Dictumst quisque sagittis purus sit amet volutpat. Donec massa sapien faucibus et molestie ac feugiat sed. Consectetur a erat nam at lectus urna duis convallis convallis.',
}
export const arrayCards: Recipe[] = [card1, card2]
