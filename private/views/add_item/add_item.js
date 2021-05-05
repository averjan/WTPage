let chosenList = document.querySelector('#current-ingredients')
let item = document.querySelector('.ingredient-select');
let name = document.querySelector('#add-cocktail-name')
let steps = document.querySelector('#add-cocktail-steps')
let strong = document.querySelector('#add-cocktail-strong')
let base = document.querySelector('#add-cocktail-base')
let taste = document.querySelector('#add-cocktail-taste')
let filename = document.querySelector('#add-cocktail-filename')
let description = document.querySelector('#add-cocktail-description')
let count = document.querySelector('#enter-count')
let measure = document.querySelector('#enter-measure')

let myUl = document.querySelector('#myUl')
let chosenItem;

document.getElementById('form-create-cocktail').addEventListener("click", e => createCocktail(e))

function addIngredient(e) {
    let temp = document.querySelector('#added-item-template').content.cloneNode(true)
    temp.querySelector('#add-item-id').value = chosenItem.value//item.value
    temp.querySelector('#add-item-count').value = count.value
    temp.querySelector('#add-item-measure').value = measure.value
    temp.querySelector('p').textContent = chosenItem.textContent //item.options[item.value].text
    console.log(temp.firstElementChild)
    chosenList.insertAdjacentHTML('beforeend', temp.firstElementChild.outerHTML);
    chosenItem.remove()
    //item.remove(item.value)
}

function removeIngredient(e) {
    let value = e.querySelector('#add-item-id').value
    let txt = e.querySelector('p').textContent
    let template = document.querySelector('#item-list-template').content.cloneNode(true).firstElementChild
    template.value = value
    template.textContent = txt
    //item.insertAdjacentHTML('beforeend', template.outerHTML);
    myUl.insertAdjacentHTML('beforeend', template.outerHTML);
    e.remove()
}

async function createCocktail(event) {

    event.preventDefault()
    let li_elements = document.getElementsByClassName('add-items-cocktail-ingredients')
    let ingredient_items = []
    for (let el of li_elements) {
        ingredient_items.push({
            count: el.querySelector('#add-item-count').value,
            id: el.querySelector('#add-item-id').value,
            measure: el.querySelector('#add-item-measure').value
        })
    }

    document.getElementById('added-array').value = JSON.stringify(ingredient_items);
    console.log(document.getElementById('added-array').value)
    document.getElementById('this-form').submit()

    /*
    let response = await fetch('/add_item/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({
            ingredients: ingredient_items,
            Name: name.value,
            Taste: taste.value,
            Strong: strong.value,
            Base: base.value,
            FileName: filename.value,
            Steps: steps.value,
            Description: description.value
        })
    });

    let result = await response.json();
     */
/*
    let formData = new FormData();

    formData.append("Name", name.value);
    formData.append("FileName", filename.value);
    formData.append("Taste", taste.value);
    formData.append("Strong", strong.value);
    formData.append("Base", base.value);
    formData.append("Steps", steps.value);
    formData.append("Description", description.value);
    formData.append("Ingredients", JSON.stringify(ingredient_items));
    console.log(JSON.stringify(ingredient_items))


    let request = new XMLHttpRequest();
    request.open("POST", "http://averkin.tim/add_item/create");
    request.send(formData);
*/

}

function searchFunction() {
    // Declare variables
    let input, filter, ul, li, a, i, txtValue;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUl");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = li[i].textContent//a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function chooseItem(e) {
    if (chosenItem == null) {
        e.style.background = 'black'
        e.style.color = 'white'
        chosenItem = e
        return
    }

    if (e === chosenItem) {
        reduceChoose(e)
    }
    else {
        e.style.background = 'black'
        e.style.color = 'white'
        reduceChoose(chosenItem)
        chosenItem = e
    }
}

function reduceChoose(e) {
    e.style.background = ''
    e.style.color = ''
    chosenItem = null
}