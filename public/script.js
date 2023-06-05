document.querySelectorAll("td").forEach(item => {
    let clicked = false;
    item.addEventListener("dblclick", event => {

        if (!clicked) {

            let id = event.currentTarget.querySelector("input[type='text']").dataset.id;
            let productName = document.querySelector("[data-id='" + id + "']");

            let newContent = event.currentTarget.querySelector("input[type='text']");
            let oldContent = newContent.value;
            let columnName = event.currentTarget.querySelector("input[type='text']").className;

            if (columnName == "stock") {
                if (confirm("Are you sure you want to modify stock value ?")) {
                    document.location.href = "/restock?id=" + id;
                }

            } else {
                let url = window.location.pathname;

                if (url == "/products") {
                    url = "http://localhost:8000/products/modifyDB";
                } else {
                    url = "http://localhost:8000/users/modifyDB";
                };
                let newBtn = document.createElement("button");
                newBtn.textContent = "✔";


                item.append(newBtn);

                newBtn.addEventListener("click", async () => {
                    if (columnName == "admin") {
                        if (newContent.value.toLowerCase() == "yes" || newContent.value == "1") {
                            newContent.value = 1;
                        } else if (newContent.value.toLowerCase() == "no" || newContent.value == "0") {
                            newContent.value = 0;
                        } else { newContent.value = oldContent.toLowerCase(); }
                    };
                    data = { id: id, content: '"' + newContent.value + '"', column: columnName, name: productName.dataset.name, oldContent: oldContent }

                    const rawResponse = await fetch(url, {
                        method: "POST",
                        headers: {
                            "Accept": "application/json",
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(data)
                    });
                    await rawResponse.json().then(window.location.reload());
                    
                });
                clicked = true;
                event.currentTarget.querySelector("input[type='text']").removeAttribute("readonly")
                event.currentTarget.querySelector("input[type='text']").classList.add("selected");
            }
        }
    })
})


if (window.location.pathname == "/restock") {

}
document.querySelectorAll("select").forEach(item => {
    item.addEventListener("change", event => {
        let span = document.querySelector(".price");
        let spanCompo = document.querySelector(".priceComponents");
        let selectProds = document.querySelector("#prods option:checked").dataset.price;
        let selectQuantity = document.querySelector("#quantity").value;
        let quantityReduc = document.querySelector("#quantity option:checked").dataset.reduction;
        let reducText;
        if (quantityReduc < 1) {
            reducText = "€, for taking " + selectQuantity + " you get a reduction of " + ((1 - quantityReduc) * 100).toFixed(2) + "% and saved " + ((selectProds * selectQuantity) * (1 - quantityReduc)).toFixed(2) + "€";
        } else {
            reducText = "€ you chosed an offer with no promotion";
        }
        spanCompo.textContent = "Price per unit is : " + selectProds + reducText;
        span.textContent = "Total amount to pay is : " + selectProds * selectQuantity * quantityReduc + "€";

        let cost = document.querySelector("#cost");
        cost.value = selectProds * selectQuantity * quantityReduc;
    })
})