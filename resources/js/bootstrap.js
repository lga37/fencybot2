window._ = require('lodash');
try {
    //window.Popper = require('popper.js').default;
    //window.$ = window.jQuery = require('jquery');


} catch (e) { }


//window.axios = require('axios');
//window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

//alert(key)

window.Echo = new Echo({
    broadcaster: 'pusher',
    authEndpoint : 'http://localhost/fencybot/public/broadcasting/auth',
    //key: process.env.MIX_PUSHER_APP_KEY,
    //cluster: process.env.MIX_PUSHER_APP_CLUSTER,

    key: window.Laravel.pusher.key,
    cluster: window.Laravel.pusher.cluster,

    //key: '7f1eb8fdd463d10f603a',
    //cluster: 'us2',

    forceTLS: true
});

window.Echo.channel('canal').listen('EventAlert', (e) => {
    alert('newmessage, canal');
    console.log(e);
});

window.Echo.channel('canal').listen('EventAlert', (e) => {
    alert(' com windownewmessage, canal');
    console.log(e);
});

window.Echo.private('canal').listen('newMessage', (e) => {
    //alert(' ggggggg com windownewmessage, canal');
    console.log(e);
});

window.Echo.private('canal').listen('newMessage', (e) => {
    //alert(' apelido com windownewmessage, canal');
    console.log(e);
});



if(Laravel.user){
    console.log(`App.User.${Laravel.user}`)
    console.log(` === ${Laravel.pusher.key}`)

    window.Echo.channel('canal').listen('newMessage',(e)=>{
        alert(333)
        console.log('chegou'+ e);
    });
    window.Echo.channel(`App.User.${Laravel.user}`).notification(ddd=>{
        console.log(ddd)
    });

}
