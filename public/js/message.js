const form = document.querySelector('#type-area')
const input = form.querySelector('#input-message')
const senBtn = document.querySelector('#send-message')
const chatBox  = document.querySelector('#chat-box')

form.onsubmit = (e)=>{
    e.preventDefault()
}


senBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest()
    xhr.open('POST','/data/insert_message.php',true)

    xhr.onload = ()=>{
        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){
                input.value = ""
                scrollToBottom()

            }
        }
    }

    let message = new FormData(form)
    xhr.send(message)
}

setInterval(() => {

    let xhr = new XMLHttpRequest()
    xhr.open('POST','/data/get_message.php',true)

    xhr.onload = ()=>{
        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){
               let data = xhr.response
               chatBox.innerHTML = data
            //    scrollToBottom()
            }
        }
    }

    let f = new FormData(form)
    xhr.send(f)

}, 600);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight + 100
}