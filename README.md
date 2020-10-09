# Settings Page WordPress Plugin

![Plugin Settings Form](https://blog.wplauncher.com/wp-content/uploads/2020/07/Screen-Shot-2020-07-05-at-2.41.54-PM.png)

Este é um plugin do WordPress que cria uma página de configurações. A página de configurações permite que usuários administradores do WordPress adicionem suas configurações para um plug-in.
Exibe uma notificação para o cliente do site sobre cookies, onde o usuário pode concordar sobre os termos, e é armazenado, todos os parâmetros são configuravéis na página de administração do plugin. 


Você pode usar este base/modelo para adicionar estrutura de banco, eventos no hooks do wordpress, uma página de configurações ao seu plugin. Este plugin faz o seguinte:

- Adiciona um item de menu de administração à barra lateral esquerda no painel de administração do WordPress junto com um item de submenu incluindo sua página de configurações

- Cria uma página de configurações que inclui um formulário
- Salva esse formulário no banco de dados
- Certifica-se de que os campos do formulário de configurações estão pré-preenchidos, se já tiver sido preenchido
- Notifica o cliente sobre o uso de cookies
- Possibilita a customização da notificação
- Tem uma tarefa que exclui as notificações expiradas de acordo com o tempo configurado nas configurações, essa tarefa é executada todos os dias.

## Instale o plug-in da página de configurações em seu site WordPress para ver o que você obtém
1. Adicione a pasta do  plugin no seu site Wordpress em wp-content\plugins
2. Faça login no seu site WordPress em www.your-wordpress-site.com/wp-login.php
3. Passe o mouse sobre Plugins na barra lateral esquerda
4. Clique em intalados
5. Ative o plugin

Após a instalação, você deverá ver a Página de Configurações na barra lateral esquerda e, ao clicar na página de Configurações, deverá ver um formulário que salva no banco de dados e é pré-preenchido quando a página é recarregada.


