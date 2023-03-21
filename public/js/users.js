let userList = document.querySelector('#user-list')
let searchBar = document.querySelector('#search-bar')

searchBar.onkeyup = ()=>{
    let searchTerm = searchBar.value
    if(searchTerm != ""){
        searchBar.classList.add("active")
    }else{
        searchBar.classList.remove("active")
    }

    let xhr = new XMLHttpRequest()
    xhr.open('POST','/data/search.php',true)

    xhr.onload = ()=>{
        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){
                let data = xhr.response
                userList.innerHTML = data
            }
        }
    }

    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded")
    xhr.send("searchTerm=" + searchTerm)
}

setInterval(() => {

    let xhr = new XMLHttpRequest()
    xhr.open('GET','/data/users.php',true)

    xhr.onload = ()=>{
        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){
               let data = xhr.response
               if(!searchBar.classList.contains("active")){
                   userList.innerHTML = data
               }
            }
        }
    }

    xhr.send(null)

}, 500);