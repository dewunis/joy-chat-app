const modal = document.querySelector('#modal')
const signupForm = document.querySelector('#signup')
const loginForm = document.querySelector('#login')
const suggestionForm = document.querySelector('#suggestion')
const loginBtn = document.querySelector('#login-btn')
const signupBtn = document.querySelector('#signup-btn')
const suggestionBtn = document.querySelector('#suggestion-btn')
const mainSignupBtn = document.querySelector('#main-signup')
const closeBtn = document.querySelectorAll('.__close')
const switchBtn = document.querySelectorAll('.__switch')
const fileInput = document.querySelector('#file')
const fileBtn = document.querySelector('#file-btn')
const erroImage = document.querySelector('#error-image-span')
const signupImage = document.querySelector('#signup-image')


mainSignupBtn.addEventListener('click' , ()=>{
    modal.classList.replace('hidden','flex')
})

closeBtn.forEach((btn)=>{
    btn.addEventListener('click', ()=>{
        modal.classList.add('hidden')
        loginForm.classList.add('hidden')
        signupForm.classList.remove('hidden')
    })
})

switchBtn.forEach((btn)=>{
    btn.addEventListener('click', ()=>{
      if(btn.id == 'signup-switch'){
        loginForm.classList.remove('hidden')
        signupForm.classList.add('hidden')
      }else{
        loginForm.classList.add('hidden')
        signupForm.classList.remove('hidden')
      }
    })
})

fileBtn.addEventListener('click',()=>{
    fileInput.click()
    const output = document.querySelector('#output')

    fileInput.onchange = (e)=>{
        valideType = [
            'image/jpeg',
            'image/jpg',
            'image/png'
        ]
        imageType = e.target.files[0].type 
        if(!valideType.includes(imageType)){
            erroImage.textContent = "Format de l'image non valide"
            erroImage.classList.remove('hidden')
            output.classList.add('hidden')
            return
        }

        output.classList.add('absolute')
        output.src = URL.createObjectURL(e.target.files[0]);

        output.onload = ()=> {
            URL.revokeObjectURL(output.src) // free memory
        }
        output.classList.remove('hidden')
        output.classList.remove('rounded-lg')
        fileBtn.classList.add('rounded-full')
        erroImage.classList.add('hidden')
    }
})


suggestionForm.onsubmit = (e)=>{
    e.preventDefault()
}

suggestionBtn.addEventListener('click',()=>{
     
    let xhr = new XMLHttpRequest()
    xhr.open('POST','/suggestion.php',true)

    xhr.onload = ()=>{
        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){

                let data = xhr.response
                let suggestionError = document.querySelector('#suggestion-error')
                console.log(data);
                if(data == 'Okay'){ 
                   
                }else{
                    suggestionError.classList.remove('hidden')
                    suggestionError.textContent = data
                }
            }
        }
    }

    let form = new FormData(suggestionForm)
    xhr.send(form)
})

// Signup and Login js

signupForm.onsubmit = (e)=>{
    e.preventDefault()
}

loginForm.onsubmit = (e)=>{
    e.preventDefault()
}

signupBtn.addEventListener('click',(e)=>{
    
    let xhr = new XMLHttpRequest()
    xhr.open('POST','/signup.php',true)

    xhr.onload = ()=>{
        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){

                let data = xhr.response
                let signupError = document.querySelector('#signup-error')

                if(data == 'Okay'){ 
                    signupError.classList.remove('hidden')
                    signupError.classList.replace('text-red-500','text-green-500')
                    signupError.textContent = 'Inscription réussie,redirection vers la page de connexion.'
                    
                    setTimeout(() => {
                        signupForm.classList.add('hidden')
                        loginForm.classList.remove('hidden')
                    }, 2000);

                }else{
                    signupError.classList.remove('hidden')
                    signupError.textContent = data
                }
            }
        }
    }

    let form = new FormData(signupForm)
    xhr.send(form)
})

loginBtn.addEventListener('click',(e)=>{
    
    let xhr = new XMLHttpRequest()
    xhr.open('POST','/login.php',true)

    xhr.onload = ()=>{
        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){

                let data = xhr.response
                let loginError = document.querySelector('#login-error')
                console.log(data == 'Okay');
                if(data == 'Okay'){ 
                   location.href = '/users.php'
                }else{
                    loginError.classList.remove('hidden')
                    loginError.textContent = data
                }
            }
        }
    }

    let form = new FormData(loginForm)
    xhr.send(form)
})



