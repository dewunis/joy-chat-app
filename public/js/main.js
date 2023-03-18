const modal = document.querySelector('#modal')
const signupForm = document.querySelector('#signup')
const loginForm = document.querySelector('#login')
const loginBtn = document.querySelector('#login-btn')
const signupBtn = document.querySelector('#signup-btn')
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
            return
        }

        const output = document.querySelector('#output')
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

signupForm.onsubmit = (e)=>{
    e.preventDefault()
}

signupBtn.addEventListener('click',(e)=>{
    if(fileBtn.querySelector('img').src = '#'){
        erroImage.classList.remove('hidden')
        return
    }

    let xhr = new XMLHttpRequest()
    xhr.open('POST','/signup.php',true)
    xhr.onload = ()=>{

    }
    xhr.send()
})



