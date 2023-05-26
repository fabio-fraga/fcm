let searchInput = document.getElementById("txtBusca")

searchInput.addEventListener("input", getProducts)

async function getProducts(e) {
    let response = await fetch("../api/products.php").then((res) => res.json())
    let filteredProducts = []
    let filteredProductsId = []
    let searchContent = document.getElementById("searchContent")

    for (let i in response) {
        if (response[i].PRO_NOME.toUpperCase().includes(e.target.value.toUpperCase())) {
            filteredProducts.push(response[i].PRO_NOME + "  |  R$ " + parseFloat(response[i].PRO_VALOR).toFixed(2))
            filteredProductsId.push(response[i].PRO_CODIGO)
        }
    }

    while (searchContent.firstChild) {
        searchContent.removeChild(searchContent.firstChild);
    }
    
    if (e.target.value.length > 0) {
        for (let i in filteredProducts) {
            let p = document.createElement("p")
            p.innerHTML = filteredProducts[i]
            p.classList.add("search-item")
            p.onclick = () => openModal(filteredProductsId[i])
            searchContent.appendChild(p)
        }
    }
    
    if (filteredProducts.length == 0) {
        let p = document.createElement("p")
        p.innerHTML = "Nenhum produto encontrado!"
        p.classList.add("search-item")
        searchContent.appendChild(p)            
    }
}
