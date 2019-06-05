import store                from "./store";
import VueRouter            from 'vue-router';
import Vue                  from 'vue';
import Default              from './Default';


Vue.use(VueRouter);
const routes = [].concat();

const Router = new VueRouter({
    mode: 'history',
    routes: routes.concat(Default),
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});

Router.beforeEach((to, from, next) => {

    let loggedin = store.getters.isLoggedin(store.state);

    console.log(loggedin);
    // console.log(token);
    if (to.meta.auth === true) {
        if (!loggedin) {
            next({
                path: '/login',
            })
        } else {
            next();
        }
    } else if(to.meta.auth === false){
        if (loggedin) {
            next(false);
        } else {
            next();
        }

    } else {
        next(); // всегда так или иначе нужно вызвать next()!

    }





});
export default Router

