export const routesMap = [
  {
    path: '/',
    name: 'home',
    component: require('./components/Home.vue'),
    meta: {
      title: 'Home'
    }
  },
  {
    path: '/decks',
    name: 'decks',
    component: require('./components/decks/List.vue'),
    meta: {
      title: 'Decks'
    },
    children: [
      {
        path: 'adding',
        name: 'deck:adding',
        component: require('./components/decks/EditDeck.vue'),
        meta: {
          title: 'Deck Adding'
        }
      }
    ]
  },
  {
    path: '/decks/:deckId',
    name: 'deck',
    meta: {
      title: 'Deck'
    },
    components: {
      default: require('./components/decks/Deck.vue'),
      'head-toolbar': require('./components/decks/HeadToolbar.vue')
    },
    // component: require('./components/decks/Deck.vue'),
    children: [
      {
        path: 'editing',
        name: 'deck:editing',
        components: {
          default: require('./components/decks/cards/List.vue'),
          frame: require('./components/decks/EditDeck.vue')
        },
        meta: {
          title: 'Deck Editing'
        }
      },
      {
        path: '',
        name: 'cards',
        component: require('./components/decks/cards/List.vue'),
        meta: {
          title: 'Deck Cards'
        },
        children: [
          {
            path: ':cardId/editing',
            name: 'card:editing',
            component: require('./components/decks/cards/EditCard.vue'),
            meta: {
              title: 'Card Editing'
            }
          },
          {
            path: 'adding',
            name: 'card:adding',
            component: require('./components/decks/cards/EditCard.vue'),
            meta: {
              title: 'Card Adding'
            }
          }
        ]
      }
    ]
  },
  {
    path: '/notes',
    name: 'notes',
    component: require('./components/notes/List.vue'),
    meta: {
      title: 'Notes'
    }
  },
  {
    path: '/notes/:noteId',
    name: 'note',
    components: {
      default: require('./components/notes/Note.vue')
      // 'head-toolbar': require('./components/notes/HeadToolbar.vue')
    },
    meta: {
      title: 'Note'
    }
  },
  {
    path: '/infos',
    name: 'infos',
    component: require('./components/Infos.vue'),
    meta: {
      title: 'Infos'
    }
  },
  {
    path: '/profile',
    name: 'profile',
    component: require('./components/user/Profile.vue'),
    meta: {
      title: 'Profile'
    }
  },
  {
    path: '/login',
    name: 'login',
    component: require('./components/user/Login.vue'),
    meta: {
      title: 'Login'
    }
  },
  {
    path: '*',
    component: require('./components/404.vue'),
    meta: {
      title: 'Not found'
    }
  }
]

export function configRouter (router) {
  router.beforeEach((route, redirect, next) => {
    // router.app.$root
    next()
  })
}
