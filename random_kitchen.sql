-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Abr-2021 às 00:51
-- Versão do servidor: 10.4.17-MariaDB
-- versão do PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `random_kitchen`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` bigint(20) UNSIGNED DEFAULT NULL,
  `rid` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `favorites`
--

INSERT INTO `favorites` (`id`, `uid`, `rid`) VALUES
(88, 228072, 743662),
(89, 228072, 743663),
(92, 985624, 743662),
(93, 985624, 743666),
(94, 985624, 743667),
(95, 985624, 743668),
(96, 985630, 743666),
(97, 985630, 743662),
(98, 985630, 743668),
(99, 985630, 743663),
(100, 580573, 743663),
(101, 580573, 743664),
(102, 580573, 743665),
(103, 985631, 743665),
(104, 985631, 743663),
(105, 985628, 743662),
(106, 985628, 743663),
(107, 985628, 743664),
(108, 228072, 743664);

-- --------------------------------------------------------

--
-- Estrutura da tabela `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author` text DEFAULT NULL,
  `authorid` bigint(20) UNSIGNED DEFAULT NULL,
  `title` text DEFAULT NULL,
  `url` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `preparationMode` text DEFAULT NULL,
  `category` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `recipes`
--

INSERT INTO `recipes` (`id`, `author`, `authorid`, `title`, `url`, `description`, `ingredients`, `preparationMode`, `category`) VALUES
(743662, 'Ze', 12365, 'Espaguete à Carbonara', 'https://s2.glbimg.com/rl_Hx0-o_LMnJrHVw2YIdCSRdUQ=/0x0:2200x1467/1000x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_1f540e0b94d8437dbbc39d567a1dee68/internal_photos/bs/2021/4/j/LtlbybQeArZdzmANvugA/espaguete-carbonara-receita-2-.jpg', 'Espaguete à Carbonara é uma receita simples e rápida de preparar. Com gemas, parmesão e bacon, o clássico italiano é uma boa opção para um almoço ou jantar especial.', '500 gramas de bacon defumado\r\n1 fio de azeite\r\nMeio pacote de espaguete\r\n300 gramas de queijo parmesão ralado\r\n4 ovos: 1 inteiro e 3 gemas\r\nSal a gosto\r\nPimenta-do-reino moída a gosto', '1. Em uma panela, coloque água para ferver com uma pitada de sal.\r\n2. Enquanto a água esquenta, use um pilão para moer os grãos de pimenta-do-reino para usar na receita.\r\n3. Em seguida, corte o bacon defumado em cubos. Não utilize o couro da peça.\r\n4. Em um fogo médio, frite o bacon defumado com 1 fio de azeite, até ficar levemente tostado. Não deixe ficar crocante.\r\n5. Com a água fervendo, coloque meio pacote de espaguete e deixe cozinhar por 7 a 8 minutos, até ficar al dente.\r\n6. Em um recipiente, coloque 300 gramas de queijo parmesão ralado, 1 ovo, 3 gemas e pimenta-do-reino moída. Com um garfo, misture os ingredientes.\r\n7. Escorra o espaguete, mas reserve a água do cozimento.\r\n8. Desligue a frigideira, acrescente o espaguete e misture com bacon.\r\n9. Em seguida, coloque 1 pitada de sal e pimenta-do-reino moída a gosto. Misture novamente.\r\n10. Depois, acrescente a mistura de parmesão com ovos, uma parte da água do cozimento do espaguete e misture mais uma vez.\r\n11. Finalize com pimenta-do-reino moída.\r\n12. Sirva em seguida.', 'Massas'),
(743663, 'Vinicius', 985624, 'Bolinha de Queijo', 'https://s2.glbimg.com/f_EzMfnj8UEtWrY8q6U7uAXb-No=/0x0:6720x4480/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_1f540e0b94d8437dbbc39d567a1dee68/internal_photos/bs/2020/v/u/zKnprdTAidjaHl9ABHmw/bolinha-de-queijo-receita-joaquim-lopes.jpeg', 'Bolinha de Queijo com apenas 4 ingredientes: claras de ovos, queijo parmesão, farinha de rosca e azeite. O aperitivo é fácil de preparar e fica pronto em apenas 15 minutos.', '2 claras de ovos\r\n150 gramas de queijo parmesão ralado\r\n100 gramas de farinha de rosca\r\nAzeite a gosto para fritar', '1. Com um batedor de arame, bata 2 claras de ovos até um pouco antes do ponto de claras em neve. O ideal é que fique com consistência, mas não muito firme.\r\n2. Em seguida, acrescente, aos poucos, 150 gramas de queijo parmesão.\r\n3. Misture o queijo parmesão e as claras até chegar em um ponto que dê para formar bolinhas.\r\n4. Coloque azeite em uma panela e deixe aquecer.\r\n5. Enquanto o azeite esquenta, faça bolinhas pequenas com as mãos.\r\n6. Em seguida, passe as bolinhas de queijo na farinha de rosca.\r\n7. Frite as bolinhas de queijo e deixe que elas fiquem bem douradas.\r\n8. Sirva em seguida.\r\n', 'Salgados'),
(743664, 'David Pavlak', 985630, 'Bolo de Nozes', 'https://s2.glbimg.com/yrL9jTdcqzuajxgCQiY73GoQuKs=/72x72:2200x1467/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_1f540e0b94d8437dbbc39d567a1dee68/internal_photos/bs/2020/d/Q/cqksXXTjuFqE6n9Wa6Xw/bolo-de-nozes-receita-joaquim-lopes.jpg', 'Bolo de Nozes com recheio de Chantilly para as festas de fim de ano. Para fazer a massa, você vai precisar apenas de 4 ingredientes: ovos, açúcar, farinha de rosca e nozes.', '9 ovos\r\n4 colheres e meia de sopa de açúcar refinado ou mascavo\r\n4 colheres e meia de sopa de farinha de rosca\r\n250 gramas de nozes trituradas\r\nManteiga e farinha de rosca para untar a assadeira', '1. Para começar, separe as claras e as gemas dos ovos. Reserve.\r\n2. Bata as claras em neve até atingir o ponto de picos firmes.\r\n3. Em seguida, adicione aos poucos as gemas na batedeira para incorporar. Bata em velocidade baixa. Reserve.\r\n4. No liquidificador, triture 250 gramas de nozes.\r\n5. Em seguida, adicione na batedeira 4 colheres e meia de sopa de açúcar refinado e 4 colheres e meia de sopa de farinha de rosca.\r\n6. Por último, acrescente as nozes trituradas.\r\n7. Unte duas formas de bolo redondas com manteiga e farinha de rosca.\r\n8. Divida a massa igualmente entre as formas. Lembre-se de que o bolo vai crescer, então deixe um espaço na forma.\r\n9. Leve ao forno preaquecido a 180 graus Celsius por aproximadamente 30 minutos. Para saber se está no ponto certo, espete um palito na massa. Se sair limpo, está pronto.', 'Bolos'),
(743665, 'Edson', 228072, 'Bacalhau ao Forno', 'https://s2.glbimg.com/RmZdaxxA8or4ZOoyaTezRxsyGy8=/0x0:2200x1467/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_1f540e0b94d8437dbbc39d567a1dee68/internal_photos/bs/2020/a/8/9A3yXxQASM0hUVDf5KVg/bacalhau-ao-forno-receita.jpg', 'receita simples e fácil de Bacalhau ao Forno para a ceia de fim de ano. Para preparar o prato, você pode usar dois tipos de bacalhau: salgado e fresco. Entre os ingredientes, estão batatas, ovos cozidos, azeitonas pretas e tomates.', '500 gramas de bacalhau salgado seco cozido no leite\r\n500 gramas de bacalhau fresco\r\n1 fio de azeite\r\n7 dentes de alho cortados em lâminas\r\n5 batatas Asterix semicozidas cortadas em rodelas\r\n3 cebolas grandes cortadas em rodelas\r\n1 pimentão vermelho cortado em rodelas\r\n1 pimentão verde cortado em rodelas\r\n1 pimentão amarelo cortado em rodelas\r\n5 tomates Débora cortados em rodelas\r\n1 vidro de azeitonas pretas portuguesas com caroço\r\n6 ovos cozidos cortados em rodelas\r\nSal a gosto\r\nAzeite a gosto\r\n1 maço de salsinha\r\nSuco de meio limão', '1. Você pode usar o bacalhau fresco com ou sem pele.\r\n2. Para retirá-la, coloque um fio de azeite na frigideira, deixe esquentar até o ponto de fumaça e coloque o bacalhau com a pele para baixo.\r\n3. Deixe o bacalhau dourar, retire da frigideira e, com o auxílio de duas colheres, retire a pele.\r\n4. Depois, com uma faca, filete o bacalhau.\r\n5. Em seguida, corte 7 dentes de alho em lâminas.\r\n6. Coloque azeite a gosto em uma travessa para começar a montagem. Depois, cubra o fundo da travessa com bacalhau salgado seco cozido com leite.\r\n7. Na sequência, distribua lâminas de alho por cima do bacalhau seco.\r\n8. Faça uma camada com rodelas de cebola.\r\n9. Depois, coloque rodelas de pimentão amarelo, verde e vermelho.\r\n10. A próxima camada é com rodelas de batatas semicozidas e tomates com sementes.\r\n11. Na sequência, adicione azeitonas pretas a gosto.\r\n12. Corte o bacalhau fresco em lascas e, em seguida, adicione na travessa.\r\n13. Acrescente mais lâminas de alho, cebolas, batatas, tomates e os pimentões.\r\n14. A seguir, coloque ovos cozidos cortados em rodelas e azeitonas pretas.\r\n15. Para finalizar a montagem, coloque sal, azeite a gosto, 1 maço de salsinha e suco de meio limão.\r\n16. Cubra a travessa com papel-alumínio.\r\n17. Leve ao forno a 180 graus Celsius por aproximadamente 30 minutos.\r\n18. Após 30 minutos, retire o papel-alumínio e deixe por mais 10 minutos no forno para dourar.\r\n19. Retire do forno e, se quiser, coloque por mais 5 minutos na resistência para dar uma tostada nos ovos e nas batatas.\r\n20. Sirva em seguida.', 'Peixes'),
(743666, 'Edson', 228072, 'Macarrão com Carne Moída', 'https://s2.glbimg.com/p9oJ7PC35Ov_hwFxQEKRUtl-yVg=/0x0:1280x720/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_1f540e0b94d8437dbbc39d567a1dee68/internal_photos/bs/2021/i/j/3pHthWRBGulL8OBEvWSQ/macarrao-com-carne-moida-do-bbb21.jpg', 'Macarrão com carne moída é um clássico prato para o final de semana', '500 gramas de patinho moído\r\n500 gramas de macarrão fusilli - parafuso - cozido al dente\r\n2 colheres de sopa de óleo\r\n1 cebola média\r\n3 colheres de sopa de extrato de tomate\r\n1 colher de sopa de orégano\r\nSal a gosto\r\nPimenta do reino a gosto', '1. Triture bem a cebola até ficar quase uma pasta.\r\n2. Numa panela, coloque o óleo e refogue a cebola até ficar transparente.\r\n3. Acrescente a carne moída, o sal, pimenta e orégano e vai refogando sempre até a carne fritar bem e criar uma crosta no fundo da panela.\r\n4. Acrescente o extrato de tomate e deixar dar uma fervida junto. Nesse momento, entre com o macarrão cozido al dente.\r\n5. Se necessário, regule o sal.', 'Massas'),
(743667, 'David Pavlak', 985630, 'Picanha Suína ao forno', 'https://s2.glbimg.com/xl1kz8ARoJC5EmDF7mv3K22RiYE=/0x0:2048x1365/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_1f540e0b94d8437dbbc39d567a1dee68/internal_photos/bs/2021/g/Y/9MoItBSSq1otD9XhhaUg/picanha-1-1-.jpg', 'Neste preparo, a picanha é temperada com salsinha, alecrim e manjericão, e regada com suco de laranja durante o cozimento. Os sabores da carne suína são valorizados pelo tempero preparado em casa e pelo aroma da laranja. É aquela refeição para dar água na boca só de olhar!', '4 colheres de sopa de sal grosso\r\nMeia xícara de chá de ervas picadas (alecrim, salsinha, manjericão)\r\n1 peça de Picanha Suína Sadia (entre 600 e 800 gramas)\r\n1 colher de sopa de manteiga\r\n2 cabeças de alho inteiras\r\nSuco de 2 laranjas', '1. Separe um pedaço de papel-alumínio e sobre o papel, coloque o sal e as ervas, espalhando a mistura pelo centro do papel.\r\n2. Besunte a peça de picanha com manteiga e passe-as pelo sal grosso com ervas.\r\n3. Deposite a picanha sobre o restante do sal e feche o papel.\r\n4. Envolva as cabeças de alho com papel-alumínio.\r\n5. Coloque a picanha e as cabeças de alho embrulhadas em uma assadeira e leve ao forno a 240 graus por 30 minutos.\r\n6. Abra o papel-alumínio da carne e regue-a com o suco das laranjas.\r\n7. Deixe a assadeira no forno por mais 10 minutos.\r\n8. Sirva a peça de picanha inteira com os dentes de alho assados para acompanhar.', 'Carnes'),
(743668, 'Edson', 228072, 'Bife a rolê', 'https://s2.glbimg.com/mQXXUirSjEkCSM_gW4lIyhho7g0=/0x0:1080x720/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_1f540e0b94d8437dbbc39d567a1dee68/internal_photos/bs/2021/4/S/YKRXpvSimdq9UlXUuIxQ/braciola-1-.jpg', 'Como fazer bracciola, prato clássico da cozinha italiana. Receita tem molho feito com cachaça; veja como preparar', 'Ingredientes - Para o bife a rolê (bracciola):\r\n1 quilo e meio de chã\r\n200 gramas de linguiças cortadas em bastões\r\n1 unidade de cenoura cortada em bastões\r\n3 unidades de ovos cozidos\r\nMeia xícara de azeitonas verdes sem caroço\r\n200 gramas de bacon cortado em tiras\r\nUm quarto de xícara de óleo\r\nBase do molho roti\r\nSal e pimenta-do-reino a gosto\r\nIngredientes - Para o molho roti:\r\n2 colheres de sopa de óleo\r\n50 gramas de manteiga\r\nMeio quilo de ossos de canela bovina\r\nMeio quilo de carré com osso\r\nMeio quilo de coxinha de frango\r\n1 unidade de cebola cortada em cubos pequenos\r\n1 unidade de cenoura cortada em cubos pequenos\r\nTalos de 1 maço de salsinha\r\nUm quarto de xícara de cachaça\r\n2 unidades de tomates pelados\r\n2 unidades de folha de louro\r\n5 grãos de pimenta preta\r\n5 grãos de pimenta branca\r\n2 litros de água\r\nSal a gosto', 'Modo de Preparo - Para o bife a rolê (bracciola):\r\n1. Limpe e corte a carne em bifes médios. Bata com um batedor de carne para afiná-los. Tempere com sal e pimenta a gosto e reserve.\r\n2. Corte os ovos cozidos em 4 pedaços e as azeitonas ao meio. Abra os bifes e sobreponha com a linguiça, os ovos, o bacon, as cenouras e as azeitonas. Enrole tudo e feche bem, amarrando-os com barbante.\r\n3. Em uma panela de pressão, coloque o óleo e deixe aquecer bem. Quando estiver bem quente, coloque as bracciolas e dourando bem todos os lados. Na mesma panela, entre com a base do molho roti e cozinhe em fogo brando na pressão, por 20 minutos.\r\n4. Desligue o fogo, tire a pressão e deixe o molho reduzir, sem tampa. Transfira as bracciolas com o molho para um refratário. Retire os barbantes e corte as bracciolas ao meio. Sirva o molho junto com a carne.\r\nModo de Preparo - Para o molho roti:\r\n1. Em uma panela grande e funda, coloque para esquentar o óleo e a manteiga. Quando estiver bem quente, coloque as carnes com os ossos. Frite bem, em fogo médio, até ficar bem dourado, pegando no fundo da panela (esse fundo ajuda na cor do molho).\r\n2. Adicione a cenoura, a cebola, os talos de salsinha e refogue bem. Coloque a cachaça e deixe evaporar. Adicione o tomate pelado, as folhas de louro, as pimentas em grão e a água. Cozinhe por 2 horas em fogo brando. Coe e reserve.', 'Carnes'),
(743669, 'Vinicius', 985624, 'Linguiça crocante com batata frita', 'https://s2.glbimg.com/3Qutci_7O3NUTEEC017HD4Xnsus=/0x0:1280x958/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_1f540e0b94d8437dbbc39d567a1dee68/internal_photos/bs/2021/v/4/7QWGqETKeXBOorilGofA/linguica-crocante-com-batata.jpg', 'A linguiça com batata frita é o pedido ideal para aquele encontro com amigos. Você vai precisar deixar o óleo bem quente para que fique bem dourada e crocante. A receita ensinada no É de Casa leva poucos ingredientes. ', '4 batatas grandes asterix\r\n800 gramas de linguiça suína fina cozida\r\n100 palitos de dente aproximadamente\r\nóleo para fritar', '1. Separe um descascador de legumes e uma mandolina para fatiar a batata.\r\n2. Descascar as batatas e laminá-las no sentido longitudinal com espessura de 1,5 milímetro. Não pode ser nem muito fina nem muito grossa. Reservar.\r\n3. Cortar as linguiças na diagonal com aproximadamente 3cm.\r\n4. Depois, uma a uma, envolver a linguiça com uma lâmina de batata e prender com um palito.\r\n5. Feito isso, fritar em óleo bem quente, esperar que fique dourada e crocante, escorrer e retirar.\r\n6. Escorrer no papel-toalha e servir.\r\n7. Sugerimos que você sirva com um molho azedo, de mostarda ou barbecue, conforme preferir.', 'Carnes');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `uid` bigint(20) UNSIGNED NOT NULL,
  `name` text DEFAULT NULL,
  `type` text DEFAULT NULL,
  `password` char(60) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `email` text DEFAULT NULL,
  `document` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`uid`, `name`, `type`, `password`, `gender`, `date`, `email`, `document`) VALUES
(12365, 'Ze', 'cozinheiro', '123456', 'M', '1999-02-13', 'testenoovo@gmail.com', '123123'),
(228072, 'Edson', 'cozinheiro', '123', 'M', '2000-08-17', 'Edson22@gmail.com', '123123'),
(580573, 'Ana', 'cozinheiro', '123456', 'F', '1999-05-19', 'Ana@gmail.com', '22225'),
(625768, 'Julia', 'aprendiz', '147852', 'F', '1995-02-21', 'Julia@gmail.com', NULL),
(985624, 'Vinicius', 'cozinheiro', '123456789', 'M', '1999-08-20', 'lopesvinicius954@gmail.com', '15978642'),
(985628, 'Edson', 'aprendiz', '123', 'M', '2021-04-01', 'edddd@gmail.com', NULL),
(985630, 'David Pavlak', 'cozinheiro', '111', 'M', '1996-10-25', 'david@gmail.com', '321123'),
(985631, 'Jhony', 'aprendiz', '123', 'M', '1998-03-19', 'jhony@gmail.com', NULL),
(985632, 'teste', 'aprendiz', '123', 'M', '2021-04-01', 'teste@teste.com', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `rid` (`rid`);

--
-- Índices para tabela `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `authorid` (`authorid`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de tabela `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=743671;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `uid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=985633;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`rid`) REFERENCES `recipes` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`authorid`) REFERENCES `users` (`uid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
