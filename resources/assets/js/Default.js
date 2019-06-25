import Home from './components/Home.vue';
import Register from './components/Register.vue';
import Login from './components/Login.vue';
import Dashboard from './components/Dashboard.vue';
import Manager from './components/Manager.vue';
import Store from './components/Store.vue';



export default [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: { auth: true},

    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: { auth: false},

    },
    {
        path: '/login',
        name: 'login',
        component: Login,

    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { auth: true},
    },
    {
        path: '/manager',
        name: 'manager',
        component: Manager,
        meta: { auth: true},
    },
    {
        path: '/store/:id',
        name: 'store',
        component: Store,
    }
]
