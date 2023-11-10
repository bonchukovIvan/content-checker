function addInput() {
    const inputFields = document.getElementById('values');
    const newDiv = document.createElement('div');
    newDiv.classList.add('value');
    newDiv.innerHTML = 
        `<button type="button" onclick="removeInput(this)">-</button>
        <label for="value">Value</label>
        <input type="text" name="values[]" id="value" class="form-control">`;
    inputFields.appendChild(newDiv);
}
function removeInput(element) {
    const inputFields = document.getElementById('values');
    inputFields.removeChild(element.parentNode);
}

function addNewInput() {
    const inputFields = document.getElementById('values');
    const newDiv = document.createElement('div');
    newDiv.classList.add('value');
    newDiv.innerHTML = 
        `<button type="button" onclick="removeInput(this)">-</button>
        <label for="value">Value</label>
        <input type="text" name="values_new[]" id="value" class="form-control">`;
    inputFields.appendChild(newDiv);
}
