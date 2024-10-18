document.addEventListener('DOMContentLoaded', function() {
    const fieldContainer = document.getElementById('fieldContainer');
    const addButton = document.getElementById('addButton');

    addButton.addEventListener('click', function() {
        addField();
    });

    function addField() {
        // Create a new div to hold the input and remove button
        const div = document.createElement('div');
        div.classList.add('field-container');

        // Create the 1st input field
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'dynamicField[]';
        input.placeholder = 'Select object type';

        const input2 = document.createElement('input2');
        input2.type = 'text';
        input2.name = 'dynamicField[]';
        input2.placeholder = 'Enter value';

        const input3 = document.createElement('input3');
        input3.type = 'text';
        input3.name = 'dynamicField[]';
        input3.placeholder = 'Enter value';

        // Create the remove button
        const removeButton = document.createElement('span');
        removeButton.classList.add('remove-button');
        removeButton.textContent = 'Remove';
        removeButton.addEventListener('click', function() {
            removeField(div);
        });

        // Append the input and remove button to the div
        div.appendChild(input);

        div.appendChild(removeButton);

        // Append the div to the field container
        fieldContainer.appendChild(div);
    }

    function removeField(div) {
        fieldContainer.removeChild(div);
    }
});