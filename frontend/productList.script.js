let host = "http://localhost/scandi/backend/init.php";

function getProducts() {
  let data = {};
  data["getProducts"] = true;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", host);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      let products = JSON.parse(xhr.responseText);
      let section = document.querySelector("section");

      for (let i = 0; i < Object.keys(products).length; i++) {
        let div = document.createElement("div");
        let label = document.createElement("label");
        let inp = document.createElement("input");
        let classTile = document.createElement("span");

        div.classList.add("checkbox");
        label.classList.add("checkbox-wrapper");
        inp.classList.add("checkbox-input", "delete-checkbox");
        classTile.classList.add("checkbox-tile");

        Object.keys(products[i]).forEach((element) => {
          let span = document.createElement("span");
          span.classList.add("checkbox-label");
          span.innerHTML = products[i][element] + "<br>";
          classTile.appendChild(span);
        });

        inp.type = "checkbox";
        inp.id = products[i]["sku"];

        label.appendChild(inp);
        label.appendChild(classTile);

        div.appendChild(label);

        section.appendChild(div);
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/json");
  xhr.send(JSON.stringify(data));
}
onload = getProducts;

function massDelete() {
  let arr = [];
  let data = {};
  let inpsDelete = document.getElementsByClassName("delete-checkbox");
  for (let i = 0; i < inpsDelete.length; i++) {
    if (inpsDelete[i].checked) {
      arr.push(inpsDelete[i].id);
    }
  }
  data["toDelete"] = arr;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", host);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      let results = xhr.responseText;
      console.log(results);
    }
  };
  xhr.setRequestHeader("Content-type", "application/json");
  xhr.send(JSON.stringify(data));
  location.reload();
}

document.getElementById("add").onclick = () =>
  window.location.replace("http://localhost/scandi/addproduct.html");
document.getElementById("delete-product-btn").onclick = massDelete;
