let searchInput = document.getElementById("txtBusca")
let searchContent = document.getElementById("searchContent")

searchInput.addEventListener("input", getProducts)

document.addEventListener("click", (e) => {
    if (e.target.id != "txtBusca") {
        searchContent.style.display = "none"
    } else {
        searchContent.style.display = "block"
    }
})

async function getProducts(e) {    
    if (e.target.value.length > 2) {
        let response = await fetch("../api/products.php?search=" + e.target.value).then((res) => res.json())
        
        cleanSearch()
        
        if (response.length > 0) {
            for (let i in response) {
                let p = document.createElement("p")
                p.innerHTML = response[i].PRO_NOME + "  |  R$ " + response[i].PRO_VALOR
                p.classList.add("search-item")
                p.onclick = () => window.location = "product_page.php?product_id=" + response[i].PRO_CODIGO
                searchContent.appendChild(p)
            }
        } else {
            let p = document.createElement("p")
            p.innerHTML = "Nenhum produto encontrado!"
            p.classList.add("search-item")
            searchContent.appendChild(p)
        }
    } else {
        cleanSearch()
    }
}

function cleanSearch() {
    while (searchContent.firstChild) {
        searchContent.removeChild(searchContent.firstChild);
    }
}
