document.querySelectorAll("td").forEach(item => {
    let clicked = false;
    item.addEventListener("dblclick", event => {

        if (!clicked) {
            let url = window.location.pathname;

            if (url == "/products"){
                url = "http://localhost:8000/products/modifyDB";
            }else {
                url = "http://localhost:8000/users/modifyDB";
            };
            let newBtn = document.createElement("button");
            newBtn.textContent = "✔";

            let id = event.currentTarget.querySelector("input[type='text']").dataset.id;
            let productName = document.querySelector("[data-id='"+id+"']");

            let newContent = event.currentTarget.querySelector("input[type='text']");
            let oldContent = newContent.value;
            let columnName = event.currentTarget.querySelector("input[type='text']").id;


            console.log(oldContent)
            item.append(newBtn);

            newBtn.addEventListener("click", async () => {

                if(columnName == "admin"){
                    if(newContent.value.toLowerCase() == "yes"){
                        newContent.value = 1;
                    } else if(newContent.value.toLowerCase() == "no") {
                        newContent.value = 0;
                    } else {newContent.value = oldContent.toLowerCase();}
                };
                data = { id: id, content: '"'+newContent.value+'"', column: columnName, name: productName.dataset.name, oldContent: oldContent }

                const rawResponse = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Accept": "application/json",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data)
                });
                const result = await rawResponse.json();
                console.log(result)
                location.reload();
            });

            clicked = true;
            event.currentTarget.querySelector("input[type='text']").removeAttribute("readonly")
            event.currentTarget.querySelector("input[type='text']").classList.add("selected");

        }
    })
})

