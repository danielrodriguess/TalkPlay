create database talkplay;

use talkplay

create table usuario(
nome varchar(60) not null,
email varchar(60) primary key,
senha varchar(12) not null,
dataa varchar(10) not null,
pergunta varchar(55) not null,
resposta varchar(55) not null,
tipo varchar(18) not null,
numerodeacesso int not null,
datahora datetime);

create table senhaalterada(
email varchar(60),
senhaantiga varchar(12) not null);

create table nick(
email varchar(60) primary key,
nick varchar(12) not null,
statususer varchar(3),
statusadmin varchar(3));

create table notificacao(
id int auto_increment primary key,
nickremetente varchar(18) not null,
imagemdodestinatario varchar(60) not null,
nickdestinatario varchar(18) not null,
notificacao varchar(255) not null,
tipo varchar(18) not null,
categoria varchar(255),
status varchar(12) not null);

create table mensagem(
id int auto_increment primary key,
nickremetente varchar(18) not null,
nickdestinatario varchar(18) not null,
mensagem varchar(255),
status varchar(12),
datahora datetime);

create table conversa(
id int,
nickremetente varchar(18) not null,
nickdestinatario varchar(18) not null,
mensagem varchar(255) not null);

create table fotodeperfil(
id int auto_increment primary key,
email varchar(60) not null,
imagem varchar(85) not null
);

create table conhecimentosgerais(
id int auto_increment primary key,
categoria varchar(50) not null,
pergunta varchar(165) not null,
alternativa1 varchar(70) not null,
alternativa2 varchar(70) not null,
alternativa3 varchar(70) not null,
alternativa4 varchar(70) not null,
alternativacerta varchar(70) not null
);

create table logica(
id int auto_increment primary key,
categoria varchar(50) not null,
pergunta varchar(165) not null,
alternativa1 varchar(70) not null,
alternativa2 varchar(70) not null,
alternativa3 varchar(70) not null,
alternativa4 varchar(70) not null,
alternativacerta varchar(70) not null
);

create table adminperguntas(
nick varchar(50) not null,
categoria varchar(50) not null,
pergunta varchar(165) not null,
alternativa1 varchar(70) not null,
alternativa2 varchar(70) not null,
alternativa3 varchar(70) not null,
alternativa4 varchar(70) not null,
alternativacerta varchar(70) not null,
status varchar(10)
);

create table jogandonomomento(
email varchar(70) not null,
jogandonomomento varchar(5) not null,
categoria varchar(30)
);

create table ranking(
email varchar(70) not null,
imagem varchar(85) not null,
categoria varchar(50) not null,
pontuacao decimal(10,2) not null
);

create table amigos(
id int primary key auto_increment,
nickremetente varchar(25),
nickdestinatario varchar(25),
status varchar(10) not null
);

create table onlinenomomento(
nick varchar(20) not null,
status varchar(5) not null
);

create table fotos(
email varchar(55),
imagem varchar(55),
atual varchar(3)
);

create table admin(
id int primary key auto_increment,
email varchar(55),
senha varchar(16),
tipo varchar(12),
status varchar(12),
codigodeseguranca varchar(15)
);

create table blok(
nickquedeu varchar(18),
nickquetomou varchar(18),
status varchar(4));

create table denuncia(
emailquedenunciou varchar(55),
emaildenunciado varchar(55),
nickdenunciado varchar(55),
descricao varchar(255),
numero int
);

create table erros(
emailqueenviou varchar(55),
descricao varchar(255)
);

create table denuncias(
emaildenunciado varchar(55),
numero int
);

create table adminnovasenha(
email varchar(55),
codigo int,
status varchar(20),
novasenha varchar(36),
numero int
);

insert into logica values(
null,
'Lógica',
'Mariana tem 2 filhas, Ana e Dora. Ela precisa dividir 30 balas entre as duas. Que horas são?',
'A- 2:45',
'B- 3:30',
'C- 1:30',
'D- 1:45',
'D- 1:45'
);

insert into logica values(
null,
'Lógica',
'Alguns meses têm 31 dias. Quantos têm 28?',
'A- 1',
'B- 12',
'C- 9',
'D- Todas as alternativas estão erradas',
'B- 12'
);

insert into logica values(
null,
'Lógica',
'x²-6x+10 = 0 então x = ?',
'A- x = ±2',
'B- x = ±v-4',
'C- x = 3±2i',
'D- Todas as alternativas estão erradas',
'C- x = 3±2i'
);

insert into logica values(
null,
'Lógica',
'Se uma pessoa for morta na divisa do Brasil e Espanha, onde ela será enterrada?',
'A- Brasil',
'B- Paraguai',
'C- Cemitério',
'D- Todas as alternativas estão erradas',
'D- Todas as alternativas estão erradas'
);

insert into logica values(
null,
'Lógica',
'Qual o próximo número da Sequência 2,10,12,16,17,18,19...?',
'A- 200',
'B- 120',
'C- 100',
'D- 20',
'A- 200'
);

insert into logica values(
null,
'Lógica',
'Um Termômetro subiu 6 graus, o que representa a metade da temperatura de antes. A quantos graus está agora?',
'A- 16 graus',
'B- 12 graus',
'C- 18 graus',
'D- 22 graus',
'C- 18 graus'
);

insert into logica values(
null,
'Lógica',
'Oito estudantes se encontram e cada um cumprimenta o outro com um aperto de mão. Quantos apertos de mão se trocaram?',
'A- 34',
'B- 28',
'C- 30',
'D- 32',
'B- 28'
);

insert into logica values(
null,
'Lógica',
'Dentre os itens abaixo, qual aquele que pode ser considerado um intruso?',
'A- Hiena',
'B- Vaca',
'C- Leão',
'D- Lobo Guará',
'B- Vaca'
);

insert into logica values(
null,
'Lógica',
'"Amigo" está para "Inimigo" assim como "Alegria" está para:',
'A- Felicidade',
'B- Sonho',
'C- Triste',
'D- Tristeza',
'D- Tristeza'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome completo do Diretor Dumbledor?(Brasil)',
'A- Dumbledor Alvo Wulfrico Brian Percival',
'B- Alvo Percival Wulfrico Brian Dumbledor',
'C- Brian Alvo Dumbledor Percival Wulfrico',
'D- Percival Alvo Dumbledor Wulfrico Brian',
'B- Alvo Percival Wulfrico Brian Dumbledor'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Do que é feito a varinha de Harry Potter?',
'A- Salguriro com pelo de unicórnio',
'B- Madeira de Plátano',
'C- Jacarandá mexicano marrom-claro',
'D- Azevinho e plumagem de fénix',
'D- Azevinho e plumagem de fénix'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Quantas casas comunais existem em Harry Potter?',
'A- Cinco',
'B- Três',
'C- Quatro',
'D- Seis',
'C- Quatro'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Quais são as Relíquias da morte?',
'A- Pedra da Ressurreição, Capa da Invisibilidade e Diário de Tom Riddle',
'B- Varinha das Varinhas, Capa da Invisibilidade e Vira-Tempo',
'C- Capa da Invisibilidade, Pedra da Ressurreição e Varinha das Varinhas',
'D- Pomo de Ouro, Varinha das Varinhas e Pedra da Ressurreição
',
'B- Varinha das Varinhas, Capa da Invisibilidade e Vira-Tempo'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Quais dessas criaturas não existem em Harry Potter?',
'A- Grifo',
'B- Diabrete-da-Cornualha',
'C- Acromântula',
'D- Sereianos',
'A- Grifo'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Em Harry Potter, onde existia um basilisco?',
'A- Câmara Secreta',
'B- Beco Diagonal',
'C- Sala Precisa',
'D- Banheiro Feminino',
'A- Câmara Secreta'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Como a cobra Nagini de Valdemort foi morta?',
'A- Cabeça cortada por Luna',
'B- Cabeça cortada por Neville',
'C- Feitiço lançado por Hermione',
'D- Esmagada por uma pedra lançada por Rony',
'B- Cabeça cortada por Neville'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Quais desses feitiços é uma maldição imperdoável?',
'A- Imperius',
'B- Sectumsempra',
'C- Expelliarmus',
'D- Expecto Patronum',
'A- Imperius'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome do efeito que ocorre quando duas varinhas com o mesmo núcleo se infrentam?',
'A- Ignis Divine',
'B- Infestissumam',
'C- Priori Incantatem',
'D- Avada Kedravra',
'C- Priori Incantatem'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Em qual filme as criaturas Sereianos aparecem?',
'A- Harry Potter e as Relíquias da Morte parte 1',
'B- Harry Potter e o Prisioneiro de Azkaban',
'C- Harry Potter e a Pedra Filosofal',
'D- Harry Potter e o Cálice de fogo',
'D- Harry Potter e o Cálice de fogo'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Oque as lágrimas da Fênix fazem?',
'A- Queimam',
'B- Corroem',
'C- Curam',
'D- Envenenam',
'C- Curam'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome da Fênix de Dumbledore?',
'A- Lestrange',
'B- Fawkes',
'C- Basilisco',
'D- Loro',
'B- Fawkes'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Quantas Horcruxes Valdemort possuia?',
'A- Cinco',
'B- Seis',
'C- Sete',
'D- Oito',
'C- Sete'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Quais desses personagens não era um Animago?',
'A- Sirius Black',
'B- Pedro Petigrew',
'C- Remo Lupin',
'D- Hagrid',
'D- Hagrid'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual é o Patrono de Harry?',
'A- Lontra',
'B- Coelho',
'C- Cervo',
'D- Alce',
'C- Cervo'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
' Qual o nome do feitiço usado para proteger Hogwarts na Batalha de Hogwarts?',
'A- Sectumsempra',
'B- Piertotum Locomotor',
'C- Expelliarmus',
'D- Protego',
'B- Piertotum Locomotor'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome do feitiço usado parar criar a barreira na Batalha de Hogwarts?',
'A- Abaffiato',
'B- Protego Maxima',
'C- Immobillus',
'D- Finite',
'B- Protego Maxima'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'A que Casa Comunal pertencia Luna Lovegood?',
'A- Sonserina',
'B- Grifinória',
'C- Lufa-Lufa',
'D- Corvinal',
'C- Lufa-Lufa'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'A que Casa Comunal pertencia Draco Malfoi?',
'A- Sonserina',
'B- Corvinal',
'C- Lufa-Lufa',
'D- Grifinória',
'A- Sonserina'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'A que Casa Comunal pertencia Neville Longbottom?',
'A- Grifinória',
'B- Lufa-Lufa',
'C- Corvinal',
'D- Sonserina',
'A- Grifinória'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'A que Casa Comunal pertencia Cedrigo Digori?',
'A- Lufa-Lufa',
'B- Corvinal',
'C- Sonserina',
'D- Grifinória',
'B- Corvinal'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome do(a) fundador(a) da Casa Comunal Lufa-Lufa?',
'A- Helga Huffle-puff',
'B- Salazar Slytherin',
'C- Godric Grifindor',
'D- Rowena Revenclaw',
'A- Helga Huffle-puff'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome do(a) fundador(a) da Casa Comunal Sonserina?',
'A- Helga Huffle-puff',
'B- Salazar Slytherin',
'C- Godric Grifindor',
'D- Rowena Revenclaw',
'B- Salazar Slytherin'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome do(a) fundador(a) da Casa Comunal Grifinória?',
'A- Helga Huffle-puff',
'B- Salazar Slytherin',
'C- Godric Grifindor',
'D- Rowena Revenclaw',
'C- Godric Grifindor'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome do(a) fundador(a) da Casa Comunal Corvinal?',
'A- Helga Huffle-puff',
'B- Salazar Slytherin',
'C- Godric Grifindor',
'D- Rowena Revenclaw',
'D- Rowena Revenclaw'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome do feitiço usado para destrancar magicamente tudo o que esteja trancado?',
'A- Apenus',
'B- Destranquius',
'C- Amonohora',
'D- Alohomora',
'D- Alohomora'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'O que foi usado para destruir o Diário de Tom Riddle?',
'A- Espada de Godric Griffindor',
'B- Feitiço Incendio',
'C- Garras de Dragão',
'D- Dente de Basilisco',
'D- Dente de Basilisco'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'O que foi usado para destruir o Anel dos Gaunt?',
'A- Varinha das Varinhas',
'B- Garras de Dragão',
'C- Dente de Basilisco',
'D- Espada de Godric Grifindor',
'D- Espada de Godric Grifindor'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Onde estava escondido o Diadema de Revenclaw?',
'A- Beco Diagonal',
'B- Cofre Gringotes',
'C- Sala Precisa',
'D- Sala de Dumbledor',
'C- Sala Precisa'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Onde Harry, Rony e Hermione encotraram um Dragão?',
'A- Beco Diagonal',
'B- Ordem da Fênix',
'C- Banco Gringotes',
'D- Azkaban',
'C- Banco Gringotes'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Quem derrubou Dumbledor da Torre?',
'A- Severo Snape',
'B- Draco Malfoy',
'C- Lucius Malfoy',
'D- Voldemort',
'A- Severo Snape'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome do(a) Professor(a) de Transfiguração?',
'A- Severo Snape',
'B- Minerva McGonagall',
'C- Remo Lupin',
'D- Pomona Sprout',
'B- Minerva McGonagall'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome do(a) Professor(a) de Herbologia?',
'A- Severo Snape',
'B- Minerva McGonagall',
'C- Remo Lupin',
'D- Pomona Sprout',
'D- Pomona Sprout'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual o nome do(a) Professor(a) de Defesa contra Artes das Trevas?',
'A- Severo Snape',
'B- Minerva McGonagall',
'C- Remo Lupin',
'D- Pomona Sprout',
'A- Severo Snape'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Sirius Black é o que de Harry Potter?',
'A- Primo',
'B- Pai',
'C- Tio',
'D- Irmão',
'C- Tio'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Quem matou Sirius Black?',
'A- Dumbledore',
'B- Voldemort',
'C- Severo Snape',
'D- Belatriz Lestrange',
'D- Belatriz Lestrange'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'A Mascote de Harry Potter era:',
'A- Rã',
'B- Rato',
'C- Cão',
'D- Coruja',
'D- Coruja'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Quantos filmes possui a franquia Harry Potter?',
'A- 7',
'B- 8',
'C- 6',
'D- 9',
'B- 8'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Quantos livros possui a franquia Harry Potter?',
'A- 7',
'B- 8',
'C- 6',
'D- 9',
'A- 7'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Quem escreveu a franquia de Harry Potter?',
'A- Edgar Alan Poe',
'B- J.K Rolling',
'C- J.R.R Tolkien',
'D- Isaac Asimov',
'B- J.K Rolling'
);

insert into conhecimentosgerais values(
null,
'Conhecimentos gerais',
'Qual foi o primeiro filme da franquia de Harry Potter?',
'A- Harry Potter e o Cálice de Fogo',
'B- Harry Potter e a Pedra Filosofal',
'C- Harry Potter e o Prisioneiro de Azakaban',
'D- Harry Potter e a Ordem da Fênix',
'B- Harry Potter e a Pedra Filosofal'
);

insert into admin values(
null,
'daniel',
'12345',
'adminchefe',
'ativo',
'5623'
);

insert into admin values(
null,
'teste',
'12345',
'admin',
'ativo',
'56231'
);