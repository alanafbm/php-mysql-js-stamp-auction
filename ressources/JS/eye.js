(function () {
    
    const iconEyeOpen = document.getElementById('icon-eye-open');
    const iconEyeClose = document.getElementById('icon-eye-close');
    const inputPassword = document.getElementById("password");

    console.log(iconEyeOpen);

    /* addEventListener for the close eye */
    iconEyeOpen.addEventListener('click', function(e){
        e.preventDefault;
        inputPassword.type = inputPassword.type == 'text' ? 'password' : 'text';

        if(inputPassword.type == 'text'){
            /* add and remove hidden class */
            iconEyeClose.classList.remove('hidden');
            iconEyeOpen.classList.add('hidden');
            
            /* addEventListener for the open eye */
            iconEyeClose.addEventListener('click', function(e){
                inputPassword.type = inputPassword.type == 'text' ? 'password' : 'text';
                /* add and remove hidden class */
                iconEyeClose.classList.add('hidden');
                iconEyeOpen.classList.remove('hidden');
            })
        }
    })
})();