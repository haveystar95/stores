import {api}                from '../assets/http';


export function registerUser(credentials){
    return new Promise((res,rej)=>{
        axios.post('/api/v1/auth/register', credentials)
            .then(response => {
                res(response.data);
            })
            .catch(err => {
                rej('An error occured.. try again later.')
            })
    })
}

export function login(credentials){
    return new Promise((res,rej)=>{
        api('login', {}, credentials).then(response => {
                res(response.data);
            })
            .catch(err => {
                rej('Wrong Email/Password combination.')
            })
    })
}

export function getLoggedinUser(){
    const userStr = JSON.parse(localStorage.getItem('user'));

    if(!userStr){
        return null
    }

    return JSON.stringify(userStr);
}
