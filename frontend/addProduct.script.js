let submit = document.getElementById("save");
let form = document.forms["form"];
let spanErrors = document.getElementsByClassName("error");
let product = {};
let errors = [];
let host = "http://localhost/scandi/backend/init.php";

// add product function
function addProduct() {
  let data = {};
  for (let i = 0; i < Object.keys(form).length; i++) {
    let name = form[i].name;
    data[name] = form[i].value;
  }
  var xhr = new XMLHttpRequest();
  xhr.open("POST", host);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      let results = JSON.parse(xhr.responseText);
      if (results == "succeed") {
        window.location.replace("http://localhost/scandi");
        console.log(results);
      } else {
        errors = results;
        Object.keys(errors).forEach((error) => {
          form[error].classList.add("valid");
          form[error].classList.add("danger");
          let span = document.querySelector(`.error.${error}`);
          span.classList.remove("hidden");
          span.innerText = errors[error];
        });
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/json"); // or "text/plain"
  xhr.send(JSON.stringify(data));
}

// create attributes function that gets the attributes from the backend
function createAttributes() {
  let data = {};
  let name = form["productType"].name;
  data[name] = form["productType"].value;
  data["getAttr"] = true;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", host);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      let attributes = JSON.parse(xhr.responseText);
      let field = document.getElementById("attributes");

      field.innerHTML = "";
      for (let i = 0; i < attributes.length; i++) {
        let div = document.createElement("div");
        let label = document.createElement("label");
        let attr = document.createElement("input");
        let spanError = document.createElement("span");

        div.classList.add("input");

        spanError.classList.add("error", "hidden", `${attributes[i]["attr"]}`);
        spanError.innerText = "This field is required";

        label.innerText = `${attributes[i]["attr"]} ( ${attributes[i]["unit"]} )`;
        label.classList.add("input-label");

        attr.type = "number";
        attr.id = attributes[i]["attr"];
        attr.name = attributes[i]["attr"];
        attr.classList.add("input-field");
        attr.onblur = validate;

        div.appendChild(attr);
        div.appendChild(label);
        div.appendChild(spanError);

        field.appendChild(div);
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/json");
  xhr.send(JSON.stringify(data));
}

// validation function
function validate() {
  for (let i = 0; i < Object.keys(form).length; i++) {
    if (form[i].value != "" && form[i].name == Object.keys(errors)[i]) {
      form[i].classList.add("valid");
      form[i].classList.remove("danger");
      let span = document.querySelector(`.error.${Object.keys(errors)[i]}`);
      span.classList.add("hidden");
    } else if (form[i].value !== "") {
      form[i].classList.add("valid");
    } else if (form[i].value == "") {
      form[i].classList.remove("valid");
    }
  }
}

// add the blur event to the inputs
for (let i = 0; i < Object.keys(form).length; i++) {
  form[i].onblur = validate;
}
document.getElementById("cancel").onclick = () => window.location.replace("http://localhost/scandi");
